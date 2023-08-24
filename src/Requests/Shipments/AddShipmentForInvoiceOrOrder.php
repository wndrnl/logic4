<?php

namespace Wndr\Logic4\Requests\Shipments;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class AddShipmentForInvoiceOrOrder extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/Shipments/AddShipmentForInvoiceOrOrder';
    }
}
