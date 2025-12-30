<?php

namespace Wndr\Logic4\Connectors;

use Saloon\Http\Auth\AccessTokenAuthenticator;
use Saloon\Http\OAuth2\GetClientCredentialsTokenRequest;
use Saloon\Http\PendingRequest;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

class Logic4Connector extends Connector
{
    use ClientCredentialsGrant, AlwaysThrowOnErrors;

    protected ?string $publicKey = null;
    protected ?string $privateKey = null;
    protected ?string $companyKey = null;
    protected ?string $username = null;
    protected ?string $password = null;
    protected ?int $administrationId = null;

    /**
     * Cached OAuth authenticator containing the access token
     */
    protected ?AccessTokenAuthenticator $oauthAuthenticator = null;

    /**
     * Buffer in seconds before token expiry to trigger re-authentication
     */
    protected int $tokenExpiryBuffer = 60;
    /**
     * @param string|null $publicKey
     * @return Logic4Connector
     */
    public function setPublicKey(?string $publicKey): Logic4Connector
    {
        $this->publicKey = $publicKey;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrivateKey(): ?string
    {
        return $this->privateKey;
    }

    /**
     * @param string|null $privateKey
     * @return Logic4Connector
     */
    public function setPrivateKey(?string $privateKey): Logic4Connector
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyKey(): ?string
    {
        return $this->companyKey;
    }

    /**
     * @param string|null $companyKey
     * @return Logic4Connector
     */
    public function setCompanyKey(?string $companyKey): Logic4Connector
    {
        $this->companyKey = $companyKey;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return Logic4Connector
     */
    public function setUsername(?string $username): Logic4Connector
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return Logic4Connector
     */
    public function setPassword(?string $password): Logic4Connector
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAdministrationId(): ?int
    {
        return $this->administrationId;
    }

    /**
     * @param int|null $administrationId
     * @return Logic4Connector
     */
    public function setAdministrationId(?int $administrationId): Logic4Connector
    {
        $this->administrationId = $administrationId;
        return $this;
    }

    public function resolveBaseUrl(): string
    {
        return getenv('LOGIC4_BASE_URL') ?: 'https://api.logic4server.nl';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Boot the connector and register authentication middleware
     */
    public function boot(PendingRequest $pendingRequest): void
    {
        $pendingRequest->middleware()->onRequest(function (PendingRequest $pendingRequest) {
            $this->ensureValidAuthentication($pendingRequest);
        });
    }

    /**
     * Ensure we have a valid access token before making the request
     */
    protected function ensureValidAuthentication(PendingRequest $pendingRequest): void
    {
        // Skip if no credentials are configured
        if (empty($this->publicKey) || empty($this->privateKey)) {
            return;
        }

        // Skip authentication for the OAuth token request itself to prevent infinite recursion
        $requestUrl = $pendingRequest->getUrl();
        if ($pendingRequest->getRequest() instanceof GetClientCredentialsTokenRequest) {
            return;
        }

        // Check if we need to (re)authenticate
        if ($this->shouldAuthenticate()) {
            $this->oauthAuthenticator = $this->getAccessToken();
        }

        // Apply the authenticator to the pending request
        if ($this->oauthAuthenticator !== null) {
            $this->oauthAuthenticator->set($pendingRequest);
        }
    }

    /**
     * Determine if we should authenticate (no token or token about to expire)
     */
    protected function shouldAuthenticate(): bool
    {
        // No authenticator yet - need to authenticate
        if ($this->oauthAuthenticator === null) {
            return true;
        }

        // Check if token has expired or is about to expire
        if ($this->oauthAuthenticator->hasExpired()) {
            return true;
        }

        // Check if token will expire within the buffer period
        $expiresAt = $this->oauthAuthenticator->getExpiresAt();

        if ($expiresAt !== null) {
            $bufferTime = (new \DateTimeImmutable())->modify("+{$this->tokenExpiryBuffer} seconds");

            if ($expiresAt <= $bufferTime) {
                return true;
            }
        }

        return false;
    }

    /**
     * Set a custom token expiry buffer in seconds
     */
    public function setTokenExpiryBuffer(int $seconds): static
    {
        $this->tokenExpiryBuffer = $seconds;

        return $this;
    }

    /**
     * Get the current OAuth authenticator
     */
    public function getOAuthAuthenticator(): ?AccessTokenAuthenticator
    {
        return $this->oauthAuthenticator;
    }

    /**
     * Set an OAuth authenticator (useful for restoring from cache)
     */
    public function setOAuthAuthenticator(?AccessTokenAuthenticator $authenticator): static
    {
        $this->oauthAuthenticator = $authenticator;

        return $this;
    }

    public function handleRetry(FatalRequestException|RequestException $exception, Request $request): bool
    {
        if ($exception instanceof RequestException && $exception->getResponse()->status() === 401) {
            // Force re-authentication on 401
            $this->oauthAuthenticator = null;
            $this->oauthAuthenticator = $this->getAccessToken();
            $request->authenticate($this->oauthAuthenticator);
        }

        return true;
    }

    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId("{$this->publicKey} {$this->companyKey} {$this->username}")
            ->setClientSecret("{$this->privateKey} {$this->password}")
            ->setDefaultScopes(['api', "administration.{$this->administrationId}"])
            ->setTokenEndpoint('https://idp.logic4server.nl/token')
            ->setRequestModifier(function (Request $request) {
                $request->headers()->set(['Content-Type'=> ' application/x-www-form-urlencoded']);
            });
    }
}
