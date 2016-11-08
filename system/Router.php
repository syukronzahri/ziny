<?php
namespace System;

class Router
{
    public $url = '';
    public $urlComponents;
    public $relativeUrlPath = '';
    public $applicationPath;
    public $defaultModule;
    public $defaultController;
    public $defaultMethod;
    private $module;
    private $controller;
    private $method;
    
    public function __construct($url = null, $relativeUrlPath = null, $applicationPath = null, $defaultModule = null, $defaultController = null, $defaultMethod = null)
    {
        if (isset($url)) {
            $this->setUrl($url);
            if (isset($relativeUrlPath)) {
                $this->setRelativeUrlPath($relativeUrlPath);
            }
        }
        if (isset($defaultModule)) {
            if (!empty($defaultModule)) {
                $this->defaultModule = $defaultModule;
            }
        }
        if (isset($defaultController)) {
            if (!empty($defaultController)) {
                $this->defaultController = $defaultController;
            }
        }
        if (isset($defaultMethod)) {
            if (!empty($defaultMethod)) {
                $this->defaultMethod = $defaultMethod;
            }
        }
        if (isset($applicationPath)){
            $this->applicationPath = $applicationPath;
        }
    }
    
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function setRelativeUrlPath($relativeUrlPath)
    {
        $this->relativeUrlPath = $relativeUrlPath;
    }

    public function setUrlComponents()
    {
        if (!empty($this->url)) {
            if (!empty($this->relativeUrlPath)) {
                $urlComponents = trim(str_replace('/' . $this->relativeUrlPath . '/', '', $this->url), '/');
                if ($urlComponents) {
                    $this->urlComponents = explode('/', $urlComponents);
                }
            }
        }
    }
    
    public function getFetchedUrl()
    {
        $this->setUrlComponents();
        $this->setModule();
        $this->setController();
        $this->setMethod();
    }
    
    public function setModule()
    {
        $checkedModuleName = null;
        
        if (count($this->urlComponents)) {
            $checkedModuleName = $this->convertToCamelCase($this->urlComponents[0]);
        }
        
        $path = $this->applicationPath . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $checkedModuleName;
        
        if (is_dir($path)) {
            $this->module = $checkedModuleName;
        } else {
            if (!empty($this->defaultModule)) {
                $this->module = $this->convertToCamelCase($this->defaultModule);
            }
        }
    }
    
    public function setController()
    {
        $checkedControllerName = null;
        $urlComponentsIndex = -1;
        
        if (!empty($this->module)) {
            $urlComponentsIndex = 1;
        } else {
            $urlComponentsIndex = 0;
        }
        
        if (isset($this->urlComponents[$urlComponentsIndex])) {
            $checkedControllerName = $this->convertToCamelCase($this->urlComponents[$urlComponentsIndex]);
        } else {
            if (empty($this->module)) {
                if (!empty($this->defaultController)) {
                    $checkedControllerName = $this->convertToCamelCase($this->defaultController);
                }
            }
        }
        
        $this->controller = $checkedControllerName;
    }
    
    public function setMethod()
    {
        $checkedMethodName = '';
        $urlComponentsIndex = -1;
        
        if (!empty($this->module) && !empty($this->controller)) {
            $urlComponentsIndex = 2;
        } else if (empty($this->controller) && !empty($this->controller)) {
            $urlComponentsIndex = 1;
        }

        if (isset($this->urlComponents[$urlComponentsIndex])) {
            $checkedMethodName = $this->convertToCamelCase($this->urlComponents[$urlComponentsIndex]);
        } else {
            if (!empty($this->defaultMethod)) {
                $checkedMethodName = $this->convertToCamelCase($this->defaultMethod);
            } else {
                $checkedMethodName = 'Index';
            }
        }
        
        $this->method = $checkedMethodName;
    }
    
    public function getModule()
    {
        return $this->module;
    }
    
    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }
    
    private function convertToCamelCase($string)
    {
        $temp = explode('-', $string);
        $words = array();
        foreach ($temp as $key => $value) {
            $words[] = ucfirst($value);
        }
        return implode('', $words);
    }
    
}