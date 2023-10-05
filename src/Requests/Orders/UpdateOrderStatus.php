<?php

namespace Wndr\Logic4\Requests\Orders;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class UpdateOrderStatus extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/Orders/UpdateOrderStatus';
    }
}
