<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class Test
{
    public function __invoke()
    {
        return Response::create(2+2);
    }
}