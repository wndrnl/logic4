<?php

namespace Wndr\Logic4\Requests\Delivery;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class CreateDeliveryForOrderRows extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/Delivery/CreateDeliveryForOrderRows';
    }
}
