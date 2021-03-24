<?php

namespace EmailMarketing\Message;

use Psr\Http\Message\StreamInterface;

/**
 * Message traits
 */
trait MessageTrait
{
    protected $headers = [];

    protected $protocol = '1.1';

    protected $stream;

    public function getProtocolVersion()
    {
        return $this->protocol;
    }

    public function withProtocolVersion($version)
    {
        $clone = clone $this;
        $clone->protocol = $version;
        return $clone;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function hasHeader($name)
    {
        return isset($this->headers[$name]);
    }

    public function getHeader($name)
    {
        if (! isset($this->headers[$name])) {
            return [];
        }

        return $this->headers[$name];
    }

    public function getHeaderLine($name)
    {
        return implode(', ', $this->getHeader($name));
    }

    public function withHeader($name, $value)
    {
        $clone = clone $this;
        $this->headers[$name] = $value;
        return $this;
    }

    public function withAddedHeader($name, $value)
    {
        # code...
    }

    public function withoutHeader($name)
    {
        $clone = clone $this;
        unset($clone->headers[$name]);
        return $clone;
    }

    public function getBody()
    {
        return $this->stream;
    }

    public function withBody(StreamInterface $body)
    {
        $clone = clone $this;
        $clone->stream = $body;
        return $clone;
    }
}
