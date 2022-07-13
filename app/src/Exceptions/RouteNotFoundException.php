<?php

declare(strict_types = 1);

namespace Socket\Chat\Exceptions;

class RouteNotFoundException extends \Exception
{
    protected $message = '404 Not Found';
}