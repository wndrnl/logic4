<?php

namespace Wndr\Logic4\Connectors;

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
    public ?int $tries = 3;
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

    public function handleRetry(FatalRequestException|RequestException $exception, Request $request): bool
    {
        if ($exception instanceof RequestException && $exception->getResponse()->status() === 401) {
            $request->authenticate($this->getAccessToken());
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
