<?php


namespace IM\Exceptions;


use Exception;

class InvalidInputContentException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid input.');
    }
}
