<?php

namespace EmailMarketing\Services\KirimEmail;

use EmailMarketing\Services\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    protected string $baseUrl;
    protected array $credentials = [];

    public function __construct(array $configuration = [])
    {
        $this->applyConfiguration($configuration);
    }

    public function applyConfiguration(array $configuration = [])
    {
        $this->baseUrl = isset($configuration['api_url']) && $configuration['api_url']
            ? $configuration['api_url']
            : null;

        if (isset($configuration['username'])) {
            $this->credentials['username'] = $configuration['username'];
        }
        if (isset($configuration['api_key'])) {
            $this->credentials['api_key'] = $configuration['api_key'];
        }
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getCredentials(): array
    {
        return $this->credentials;
    }

    public function getDefaultHeaders(): array
    {
        $timestamp = time();
        $credentials = $this->getCredentials();
        $generatedToken = $this->generateToken($timestamp);

        return [
            'X-Requested-With' => 'XMLHttpRequest',
            'Auth-Id' => $credentials['username'],
            'Auth-Token' => $generatedToken,
            'Timestamp' => $timestamp,
        ];
    }

    public function getHttpClientOptions(): array
    {
        return [];
    }

    public function generateToken($timestamp)
    {
        try {
            $credentials = $this->getCredentials();
            return hash_hmac('sha256', $credentials['username'].'::'.$credentials['api_key'].'::'.$timestamp, $credentials['api_key']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}