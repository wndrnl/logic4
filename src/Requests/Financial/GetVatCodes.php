<?php

namespace Wndr\Logic4\Requests\Financial;

use Wndr\Logic4\Requests\Abstracts\GetRequest;

class GetVatCodes extends GetRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/Financial/GetVatCodes';
    }
}
