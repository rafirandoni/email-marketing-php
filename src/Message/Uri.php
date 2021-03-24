<?php

namespace EmailMarketing\Message;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    protected $scheme;

    protected $host;

    protected $port;

    protected $path;

    protected $userInfo;

    protected $query;

    protected $fragment;

    public function __construct($uri = '')
    {
        if ($uri) {
            $this->applyParts($this->parse($uri));
        }
    }

    public function parse($uri)
    {
        return parse_url($uri);
    }

    public function applyParts($parts)
    {
        $this->scheme = isset($parts['scheme'])
            ? $parts['scheme']
            : '';
        $this->host = isset($parts['host'])
            ? $parts['host']
            : '';
        $this->port = isset($parts['port'])
            ? $parts['port']
            : '';
        $this->path = isset($parts['path'])
            ? $parts['path']
            : '';
        $this->userInfo = isset($parts['userInfo'])
            ? $parts['userInfo']
            : '';
        $this->query = isset($parts['query'])
            ? $parts['query']
            : '';
        $this->fragment = isset($parts['fragment'])
            ? $parts['fragment']
            : '';
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getAuthority()
    {
        $authority = '';
        if ($this->getUserInfo()) {
            $authority = $this->getUserInfo().'@';
        }

        $authority .= $this->getHost();

        if ($this->getPort()) {
            $authority .= ':'.$this->getPort();
        }

        return $authority;
    }

    public function getUserInfo()
    {
        return $this->userInfo;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getQuery()
    {
        //
    }

    public function getFragment()
    {
        return $this->fragment;
    }

    public function withScheme($scheme)
    {
        $clone = clone $this;
        $this->scheme = $scheme;
        return $clone;
    }

    public function withUserInfo($user, $password = null)
    {
        $clone = clone $this;
        $clone->userInfo = $user.':'.$password;
        return $clone;
    }

    public function withHost($host)
    {
        $clone = clone $this;
        $clone->host = $host;
        return $clone;
    }

    public function withPort($port)
    {
        $clone = clone $this;
        $clone->port = $port;
        return $clone;
    }

    public function withPath($path)
    {
        $clone = clone $this;
        $clone->path = $path;
        return $clone;
    }

    public function withQuery($query)
    {
        $clone = clone $this;
        $clone->query = $query;
        return $clone;
    }

    public function withFragment($fragment)
    {
        $clone = clone $this;
        $clone->fragment = $fragment;
        return $clone;
    }

    public function __toString()
    {
        $uri = '';

        if ($this->getScheme()) {
            $uri .= $this->getScheme().':';
        }

        if ($this->getAuthority() !== '' || $this->getScheme() === 'file') {
            $uri .= '//'.$this->getAuthority();
        }

        $uri .= $this->getPath();

        if ($this->getQuery()) {
            $uri .= '?'.$this->getQuery();
        }

        if ($this->getFragment()) {
            $uri .= '#'.$this->getFragment();
        }

        return $uri;
    }

}
