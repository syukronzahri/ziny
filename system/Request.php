<?php
namespace System;

use System\Security;

class Request
{
    private $input;
    private $haveToCleanInput = false;
    
    public function __construct($post, $get, $request)
    {
        $this->input['post'] = $post;
        $this->input['get'] = $get;
        $this->input['request'] = $request;
    }
    
    public function cleanInput($flag)
    {
        if ($flag === true) {
            $this->haveToCleanInput = true;
        } else {
            $this->haveToCleanInput = false;
        }
    }
    
    public function post($clean = true)
    {
        if (isset($clean)) {
            if ($clean) {
                return $this->recursiveClean($this->input['post']);
            }
        } else {
            if ($this->haveToCleanInput) {
                return $this->recursiveClean($this->input['post']);   
            }
        }
        return $this->input['post'];
    }

    public function get($clean = true)
    {
        if (isset($clean)) {
            if ($clean) {
                return $this->recursiveClean($this->input['get']);
            }
        } else {
            if ($this->haveToCleanInput) {
                return $this->recursiveClean($this->input['get']);   
            }
        }
        return $this->input['get'];
    }
    
    public function request($clean = true)
    {
        if (isset($clean)) {
            if ($clean) {
                return $this->recursiveClean($this->input['request']);
            }
        } else {
            if ($this->haveToCleanInput) {
                return $this->recursiveClean($this->input['request']);   
            }
        }
        return $this->input['request'];
    }
    
    private function recursiveClean($array)
    {
        $tempArray = array();
        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                $tempArray[] = Security::htmlEncode($value);
            } else {
                $tempArray[] = $this->recursiveClean($value);
            }
        }
        return $tempArray;
    }
}