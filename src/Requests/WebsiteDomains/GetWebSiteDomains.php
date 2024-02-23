<?php


namespace Wndr\Logic4\Requests\WebsiteDomains;

use Saloon\Enums\Method;
use Saloon\Traits\Body\HasBody;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody as HasBodyContract;
use Wndr\Logic4\Requests\Abstracts\GetRequest;
use Wndr\Logic4\Requests\Abstracts\PostRequest;

class GetWebSiteDomains extends GetRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/WebsiteDomains/GetWebSiteDomains';
    }
}
