<?php


namespace Wndr\Logic4\Requests\WebsiteDomains;

use Wndr\Logic4\Requests\Abstracts\GetRequest;

class GetWebSiteDomains extends GetRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/WebsiteDomains/GetWebSiteDomains';
    }
}
