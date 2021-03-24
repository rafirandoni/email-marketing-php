<?php

namespace EmailMarketing\Services;

interface ConfigurationInterface
{
    public function getBaseUrl(): string;

    public function getCredentials(): array;

    public function getDefaultHeaders(): array;

    public function getHttpClientOptions(): array;
}