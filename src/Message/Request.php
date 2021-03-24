<?php

namespace EmailMarketing\Message;

use Psr\Http\Message\RequestInterface;
use Laminas\Diactoros\Request as BaseRequest;

class Request extends BaseRequest implements RequestInterface
{
    public function __construct($uri = null, string $method = null, $body = 'php://temp', array $headers = [])
    {
        if (is_null($body)) {
            $body = 'php://memory';
        }

        parent::__construct($uri, $method, $body, $headers);
    }
}
