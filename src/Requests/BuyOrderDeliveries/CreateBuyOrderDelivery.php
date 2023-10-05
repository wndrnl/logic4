<?php

namespace Wndr\Logic4\Requests\BuyOrderDeliveries;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class CreateBuyOrderDelivery extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/BuyOrderDeliveries/CreateBuyOrderDelivery';
    }
}
