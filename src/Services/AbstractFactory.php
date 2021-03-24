<?php

namespace EmailMarketing\Services;

use Psr\Http\Client\ClientInterface;

class AbstractFactory
{
    protected $configuration;

    protected $httpClient;

    public function __construct()
    {
        //
    }

    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function __get($property)
    {
        $class = $this->getQualifiedClassName($this->cleanClassName($property));
        if (! class_exists($class)) {
            throw new \Exception('Class '.$class.' not found');
        }

        return new $class($this->httpClient, $this->configuration);
    }

    public function hasClass(string $className, $service = null)
    {
        $class = $this->getQualifiedClassName($className, $service);

        if (! class_exists($class)) {
            return false;
        }

        return true;
    }

    public function getConfigurationObject(array $configuration)
    {
        $configurationClass = $this->getQualifiedClassName('Configuration', null, false);
        if (! class_exists($configurationClass)) {
            throw new \Exception('Configuration class not exists');
        }

        return new $configurationClass($configuration);
    }

    public function getQualifiedClassName(string $className, $service = null, bool $useSuffix = true)
    {
        $className = ucfirst(strtolower($className));

        if (is_null($service)) {
            $service = get_class($this);
        }

        $serviceReflection = (new \ReflectionClass($service));

        $classSuffix = ($useSuffix)
            ? $this->getClassSuffix()
            : null;

        return $serviceReflection->getNamespaceName().'\\'.$className.$classSuffix;
    }

    public function getClassSuffix()
    {
        if (! property_exists($this, 'classSuffix')) {
            return null;
        }
        return $this->classSuffix;
    }

    public function cleanClassName(string $className)
    {
        return ucfirst(strtolower($className));
    }
}
