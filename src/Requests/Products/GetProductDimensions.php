<?php

namespace Wndr\Logic4\Requests\Products;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class GetProductDimensions extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/Products/GetProductDimensions';
    }
}
