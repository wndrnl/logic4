<?php

namespace Wndr\Logic4\Requests\Orders;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class GetOrderStatuses extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/Orders/GetOrderStatuses';
    }
}
