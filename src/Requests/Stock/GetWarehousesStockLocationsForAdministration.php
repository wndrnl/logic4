<?php

namespace Wndr\Logic4\Requests\Stock;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class GetWarehousesStockLocationsForAdministration extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/Stock/GetWarehousesStockLocationsForAdministration';
    }
}
