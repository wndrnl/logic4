<?php


namespace Wndr\Logic4\Requests\Orders;

use Saloon\Enums\Method;
use Saloon\Traits\Body\HasBody;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody as HasBodyContract;
class CreateAndProcessInvoiceForOrder extends Request implements HasBodyContract
{
    use HasBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected int $orderId
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/Orders/CreateAndProcessInvoiceForOrder';
    }

    public function defaultBody(): string
    {
        return (string)$this->orderId;
    }
}
