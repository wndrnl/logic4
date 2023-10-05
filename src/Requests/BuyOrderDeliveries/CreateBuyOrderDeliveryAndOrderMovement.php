<?php

namespace Wndr\Logic4\Requests\BuyOrderDeliveries;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class CreateBuyOrderDeliveryAndOrderMovement extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/BuyOrderDeliveries/CreateBuyOrderDeliveryAndOrderMovement';
    }
}
