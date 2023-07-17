<?php

namespace Wndr\Logic4\Requests\Orders;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class GetOrders extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1.2/Orders/GetOrders';
    }
}
