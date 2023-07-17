<?php

namespace Wndr\Logic4\Requests\Products;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class GetProducts extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1.1/Products/GetProducts';
    }
}
