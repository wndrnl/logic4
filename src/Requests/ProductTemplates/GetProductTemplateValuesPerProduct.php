<?php

namespace Wndr\Logic4\Requests\ProductTemplates;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class GetProductTemplateValuesPerProduct extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/ProductTemplates/GetProductTemplateValuesPerProducts';
    }
}
