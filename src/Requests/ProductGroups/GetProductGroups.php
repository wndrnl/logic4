<?php

namespace Wndr\Logic4\Requests\ProductGroups;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class GetProductGroups extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/ProductGroups/GetProductGroups';
    }
}
