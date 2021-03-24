<?php

namespace EmailMarketing\Message;

use Laminas\Diactoros\Response as BaseResponse;
use Psr\Http\Message\ResponseInterface;

class Response extends BaseResponse implements ResponseInterface
{
    public function __construct($body = 'php://memory', int $status = 200, array $headers = [])
    {
        parent::__construct($body, $status, $headers);
    }
}
