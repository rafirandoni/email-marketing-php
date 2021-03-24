<?php

namespace EmailMarketing\Services\KirimEmail;

use EmailMarketing\Message\Request;
use EmailMarketing\Services\AbstractService;
use EmailMarketing\Services\ConfigurationInterface;
use EmailMarketing\Services\ListInterface;
use Psr\Http\Client\ClientInterface;

class ListService extends AbstractService implements ListInterface
{
    public function __construct(ClientInterface $httpClient, ConfigurationInterface $configuration)
    {
        parent::__construct($httpClient, $configuration);
    }

    public function get(array $conditions = [])
    {
        $method = 'GET';

        if (isset($conditions['id'])) {
            $uriPath = '/v3/list/'.$conditions['id'];
        } else {
            $uriPath = '/v3/list';
        }

        $request = new Request($uriPath, $method);
        $sendRequest = $this->send($request);
        return json_decode($sendRequest->getBody()->getContents());
    }

    public function create(array $params = [])
    {
        $method = 'POST';
        $uriPath = '/v3/list';
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];

        $request = new Request($uriPath, $method, 'php://memory', $headers);
        $request->getBody()->write(json_encode($params));

        $sendRequest = $this->send($request);
        return json_decode($sendRequest->getBody()->getContents());
    }

    public function update(?string $uniqueID, array $params = [])
    {
        $method = 'PUT';
        $uriPath = '/v3/list/'.$uniqueID;
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];

        $request = new Request($uriPath, $method, 'php://memory', $headers);
        $request->getBody()->write(json_encode($params));

        $sendRequest = $this->send($request);
        return json_decode($sendRequest->getBody()->getContents());
    }

    public function delete(?string $uniqueID)
    {
        //
    }
}
