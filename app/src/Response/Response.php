<?php

namespace Socket\Chat\Response;

class Response implements ResponseInterface
{

    private $statusCode = 'HTTP/1.1 200 OK';
    private $headers = [];

    public function addHeader($name, $value){
        $this->headers[$name][] = $value;
    }

    public function setHeader($name, $value){
        $this->headers[$name] = [
            (string) $value,
        ];
    }

    public function redirect($url){
        $this->setHeader('Location', $url);
    }

    public function setStatusCode($statusCode)
    {
        // TODO: Implement setStatusCode() method.
    }

    public function setContentType($contentType)
    {
        // TODO: Implement setContentType() method.
    }
}