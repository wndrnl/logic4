<?php

namespace Wndr\Logic4\Requests\Abstracts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

abstract class PostRequest extends Request implements HasBody
{
    use HasJsonBody;
    protected Method $method = Method::POST;
    public function __construct(
        protected mixed $b
    ){}

    protected function defaultBody(): array
    {
        return $this->b;
    }
}
