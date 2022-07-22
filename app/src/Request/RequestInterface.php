<?php
namespace Socket\Chat\Request;
interface RequestInterface
{
    public function get($key, $default = null);
    public function post($key, $default = null);
    public function server($key, $default = null);
    public function getMethod();
}