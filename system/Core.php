<?php
namespace System/Core;

use System/Core/Exception;
use System/Core/Router;
use System/Core/Request;
use System/Core/Environment;

class Core
{
    public $router;
    public $security;
    public $request;
    public $environment;
    
    public function __construct()
    {
        $this->router = new Router(REQUEST_URL, RELATIVE_URL_PATH);
        $this->request = new Request($_POST, $_GET, $_REQUEST);
        $this->environment = new Environment();
    }
    
    public function run()
    {
        $controllerName = $this->router->getController();
        $methodName = $this->router->getMethod();
        
        $controllerFile = CONTROLLER_PATH . DIRECTORY_SEPARATOR . $controllerName . '.php';
        if (!file_exists($controllerFile)) {
            //throw new \Exception("Controller file {$controllerFile}.php doesn't exist");
            exit("Controller file {$controllerFile} doesn't exist");
            return;
        } else {
            require_once(CONTROLLER_PATH . DIRECTORY_SEPARATOR . $controllerName . '.php');
            $controllerClass = "\\Controller\\" . $controllerName;
            $controller = new $controllerClass($this->request);
            if (!method_exists($controller, $methodName)) {
                //throw new Exception("Controller file {$controllerFile}.php doesn't exist");
                exit("Method {$methodName} doesn't exist in controller {$controllerName}");
            } else {
                $controller->$methodName();
            }
        }
    }
}