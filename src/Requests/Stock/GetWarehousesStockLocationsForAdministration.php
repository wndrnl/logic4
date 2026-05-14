<?php


namespace Wndr\Logic4\Requests\Stock;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasStringBody;

class GetWarehousesStockLocationsForAdministration extends Request implements HasBody
{
    use HasStringBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected int $administrationId
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/Stock/GetWarehousesStockLocationsForAdministration';
    }

    public function defaultBody(): string
    {
        return (string)$this->administrationId;
    }
}
