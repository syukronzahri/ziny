<?php
namespace System;

use Ziny;
use System\View;

class Controller
{
    protected $view;
    
    public function __construct()
    {
        $directory = str_replace('\\', DIRECTORY_SEPARATOR, str_replace('Controller\\', '', get_class($this)));
        $this->view = new View($directory);
    }
}