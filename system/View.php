<?php
namespace System;

use Ziny;

class View
{
    public $directory;
    
    public function __construct($path)
    {
        $this->setDirectory($path);
    }
    
    public function setDirectory($path)
    {
        $this->directory = $path;
    }
    
    public function renderPartial($view, $data = null)
    {
        $view = $this->loadView($view, $data);
        echo $view;
    }
    
    public function render($view, $data = null, $container = null)
    {
        $content = $this->loadView($view, $data);
        
        $dataToRender = array(
            'content' => $content
        );
        
        if ($container) {
            $view = $this->loadView($container, $dataToRender);
            echo $view;
        } else {
            echo $content;
        }
    }
    
    private function loadView($view, $data = null)
    {
        if (isset($data)) {
            if (count($data)) {
                extract($data);
            }
        }

        $viewPath = Ziny::$environment->applicationPath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->directory . DIRECTORY_SEPARATOR . $view . '.php';

        ob_start();
        
        require($viewPath);
        $viewContent = ob_get_contents();
        
        ob_end_clean();
        
        return $viewContent;
    }
}