<?php


namespace IM\Exceptions;


use Exception;

class OverlappingDatesException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
