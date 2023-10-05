<?php


namespace Wndr\Logic4\Requests\Stock;

use Saloon\Enums\Method;
use Saloon\Traits\Body\HasBody;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody as HasBodyContract;
use Wndr\Logic4\Requests\Abstracts\PostRequest;

class GetStockForWarehouses extends PostRequest
{
    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/v1/Stock/GetStockForWarehouses';
    }
}
