<?php

namespace EmailMarketing\Services\KirimEmail;

use EmailMarketing\Services\AbstractFactory;
use EmailMarketing\Services\ServiceFactoryInterface;
use Psr\Http\Client\ClientInterface;

class Factory extends AbstractFactory implements ServiceFactoryInterface
{
    protected $classSuffix = 'Service';

    public function __construct()
    {
        //
    }
}
