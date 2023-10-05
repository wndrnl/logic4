<?php


namespace Wndr\Logic4\Requests\Stock;

use Saloon\Enums\Method;
use Saloon\Traits\Body\HasBody;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody as HasBodyContract;
class GetWarehousesStockLocationsForAdministration extends Request implements HasBodyContract
{
    use HasBody;

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
