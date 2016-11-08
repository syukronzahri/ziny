<?php

use System\Exception;
use System\Router;
use System\Request;
use System\Environment;

class Ziny
{
    private static $config;
    public static $router;
    public static $security;
    public static $request;
    public static $environment;
    private $applicationMode;
    
    public function __construct($requestUrl, $fullUrl, $relativeUrlPath, $systemPath, $applicationPath, $baseFolderName, $relativeBasePath, $baseUrl, $config)
    {
        self::$config = $config;
        self::$router = new Router($requestUrl, $relativeUrlPath, $applicationPath, self::$config['route']['default']['module'], self::$config['route']['default']['controller'], self::$config['route']['default']['method']);
        self::$router->getFetchedUrl();
        self::$request = new Request($_POST, $_GET, $_REQUEST);
        if (self::$config['security']['cleanInput']) {
            self::$request->cleanInput(true);
        }
        self::$environment = new Environment();
        self::$environment->baseFolderName = $baseFolderName;
        self::$environment->relativeBasePath = $relativeBasePath;
        self::$environment->baseUrl = $baseUrl;
        self::$environment->systemPath = $systemPath;
        self::$environment->applicationPath = $applicationPath;
        self::$environment->requestUrl = $requestUrl;
        self::$environment->fullUrl = $fullUrl;
        
        $this->applicationMode = ENVIRONMENT;
    }
    
    public static function setRouter($routerObject)
    {
        self::$router = $routerObject;
    }
    
    public static function setRequest($requestObject)
    {
        self::$request = $requestObject;
    }
    
    public function run()
    {
        $moduleName = self::$router->getModule();
        $controllerName = self::$router->getController();        
        $methodName = self::$router->getMethod();
        
        $controllerClassPath = 'Controller\\';
        $action = 'actionIndex';
        
        if ($moduleName) {
            $controllerClassPath .= $moduleName . "\\";
        }
        
        if ($controllerName) {
            $controllerClassPath .= $controllerName;
        } else {
            throw new Exception("No default controller is set");
        }
        
        if ($methodName) {
            $action = 'action' . $methodName;
        } else {
            throw new Exception("No default method is set");
        }

        try {
            $controller = new $controllerClassPath();
        } catch (Exception $e) {
            echo 'hahahaha';
            echo $e->getMessage();
        }
        
        if (!method_exists($controller, $action)) {
            throw new Exception("Method {$methodName} of Controller {$controllerName} doesn't exist");
        } else {
            try {
                $controller->$action();
            } catch (Exception $e){
                echo $e->getMessage();
            }
        }
    }
    
    public static function getConfig()
    {
        return self::$config;
    }

    public function viewNotFound()
    {
        if ($this->applicationMode == 'development' || $this->applicationMode == 'testing') {
            echo '<p>The page you are looking for is not found</p>';
            echo '<p>' . self::$router->getModule . '/' . self::$router->getController() . '/' . self::$router->getMethod() . '</p>';
        } else {
            echo '<p>Sorry, the page you are looking for is not found</p>';
        }
    }
}