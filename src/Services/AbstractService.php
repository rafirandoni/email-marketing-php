<?php

namespace EmailMarketing\Services;

use EmailMarketing\Message\Request;
use EmailMarketing\Message\Uri;
use Psr\Http\Client\ClientInterface;

class AbstractService
{
    protected $httpClient;

    protected $configuration;

    public function __construct(ClientInterface $httpClient, ConfigurationInterface $configuration)
    {
        $this->httpClient = $httpClient;
        $this->configuration = $configuration;
    }

    public function send(Request $request, $options = [])
    {
        if ($headers = $this->configuration->getDefaultHeaders()) {
            foreach ($headers as $key => $value) {
                $request = $request->withHeader($key, $value);
            }
        }

        if (! $request->getUri()->getHost()) {
            $baseUrl = $this->configuration->getBaseUrl();
            $uriPath = $baseUrl.'/'.ltrim($request->getUri(), '/');

            $request = $request->withUri(new Uri($uriPath));
        }

        if (isset($options['beforeSend'])) {
            if (is_callable($options['beforeSend'])) {
                $options['beforeSend']($request);
            }
        }

        $sendRequest = $this->httpClient->sendRequest($request);

        return $sendRequest;
    }

    public function sendRequest($request)
    {
        # code...
    }
}
