<?php

namespace Wndr\Logic4\Requests\BuyOrderDeliveries;

use Wndr\Logic4\Requests\Abstracts\GetRequest;

class GetBuyOrderDeliveryStatusses extends GetRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/BuyOrderDeliveries/GetBuyOrderDeliveryStatusses';
    }
}
