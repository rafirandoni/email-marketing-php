<?php

namespace EmailMarketing;

use EmailMarketing\Services\ConfigurationInterface;
use EmailMarketing\Services\ServiceFactoryInterface;
use Psr\Http\Client\ClientInterface;

class Factory
{
    protected ClientInterface $httpClient;

    protected ServiceFactoryInterface $factory;

    public function __construct(string $httpClient, string $factory, array $configuration = [])
    {
        if (! (new \ReflectionClass($httpClient))->implementsInterface(ClientInterface::class)) {
            throw new \Exception('Class '.$httpClient.' must implement Psr\Http\Client\ClientInterface');
        }
        if (! (new \ReflectionClass($factory))->implementsInterface(ServiceFactoryInterface::class)) {
            throw new \Exception('Class '.$factory.' must implement EmailMarketing\Services\ServiceFactoryInterface');
        }

        $this->factory = new $factory();
        $this->factory->setConfiguration($this->factory->getConfigurationObject($configuration));
        $this->factory->setHttpClient(new $httpClient);
    }

    public function __get($property)
    {
        if ($this->factory->hasClass($property)) {
            return $this->factory->{$property};
        }

        throw new \Exception('Cant handle '.$property.' property');
    }
}
