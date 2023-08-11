<?php

namespace Wndr\Logic4\Requests\BuyOrders;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class GetBuyOrders extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1.1/BuyOrders/GetBuyOrders';
    }
}
