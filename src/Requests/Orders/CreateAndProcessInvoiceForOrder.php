<?php


namespace Wndr\Logic4\Requests\Orders;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasStringBody;

class CreateAndProcessInvoiceForOrder extends Request implements HasBody
{
    use HasStringBody;

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
