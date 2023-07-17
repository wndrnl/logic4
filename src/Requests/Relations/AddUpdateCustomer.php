<?php

namespace Wndr\Logic4\Requests\Relations;

use Wndr\Logic4\Requests\Abstracts\PostRequest;

class AddUpdateCustomer extends PostRequest
{
    public function resolveEndpoint(): string
    {
        return '/v1/Relations/AddUpdateCustomer';
    }
}
