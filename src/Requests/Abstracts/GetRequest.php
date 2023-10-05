<?php

namespace Wndr\Logic4\Requests\Abstracts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

abstract class GetRequest extends Request
{
    protected Method $method = Method::GET;
}
