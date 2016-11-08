<?php
namespace System;

class Database extends PDO
{
    public $hostName;
    public $userName;
    public $password;
    public $databaseName;
    public $statement;
    public $result;
    
    public function __construct($dbType, $host, $user, $pass, $dbName)
    {
        parent::__construct("{$dbType}:host={$host};dbname={$dbName}", $user, $pass);
        parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function 
}