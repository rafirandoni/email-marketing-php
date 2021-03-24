<?php

namespace EmailMarketing\Services\KirimEmail;

use EmailMarketing\Message\Request;
use EmailMarketing\Services\AbstractService;
use EmailMarketing\Services\ConfigurationInterface;
use Psr\Http\Client\ClientInterface;

class SubscriberService extends AbstractService
{
    public function __construct(ClientInterface $httpClient, ConfigurationInterface $configuration)
    {
        parent::__construct($httpClient, $configuration);
    }

    public function get(array $conditions = [])
    {
        # code...
    }

    public function subscribe(string $listID, array $params = [])
    {
        $method = 'POST';
        $uriPath = '/v3/subscriber';
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];

        $params['lists'] = $listID;

        $request = new Request($uriPath, $method, 'php://memory', $headers);
        $request->getBody()->write(json_encode($params));

        $sendRequest = $this->send($request);
        return json_decode($sendRequest->getBody()->getContents());
    }

    public function unsubscribe(string $listID, array $params = [])
    {
        $method = 'DELETE';
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'List-Id' => $listID,
        ];

        if (isset($params['email'])) {
            $uriPath = '/v3/subscriber/email/'.$params['email'];
        } else if (isset($params['id'])) {
            $uriPath = '/v3/subscriber/'.$params['id'];
        }

        $request = new Request($uriPath, $method, 'php://temp', $headers);
        $sendRequest = $this->send($request);
        return json_decode($sendRequest->getBody()->getContents());
    }
}
