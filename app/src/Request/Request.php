<?php

namespace Socket\Chat\Request;

class Request implements RequestInterface
{
    public function __construct(
        protected $get,
        protected $post,
        protected $files,
        protected $server,
        protected $cookies
    )
    {

    }


    public function get($key, $defaultValue = null)
    {
        return $this->get->get($key, $defaultValue);
    }

    public function post($key, $defaultValue = null)
    {
        return $this->post->get($key, $defaultValue);
    }

    public function server($key, $default = null)
    {
        // TODO: Implement server() method.
    }

    public function getMethod()
    {
        // TODO: Implement getMethod() method.
    }
}