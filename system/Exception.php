<?php
namespace System;

class Exception extends \Exception
{
    public $message;
    
    public function __construct($message)
    {
        $this->message = $message;
    }
    
    public function getExceptionMessage()
    {
        echo $this->message . '<br>';
    }
}