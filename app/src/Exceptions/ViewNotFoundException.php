<?php

declare(strict_types = 1);

namespace Socket\Chat\Exceptions;

class ViewNotFoundException extends \Exception
{
    protected $message = 'View not found';
}