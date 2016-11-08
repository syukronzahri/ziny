<?php
namespace System;

class Security
{
    public static function htmlEncode($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    public static function htmlDecode($string)
    {
        return htmlspecialchars_decode($string, ENT_QUOTES);
    }
}