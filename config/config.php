<?php

$config = [];

/* 
==========================
Database
==========================
*/
$config['database']['default']['dsn'] = '';
$config['database']['default']['driver'] = 'mysql';
$config['database']['default']['hostname'] = 'localhost';
$config['database']['default']['port'] = '3306';
$config['database']['default']['username'] = 'root';
$config['database']['default']['password'] = '';
$config['database']['default']['database'] = '';

/* 
==========================
Route
==========================
*/
$config['route']['default']['module'] = '';
$config['route']['default']['controller'] = 'welcome-to-ziny';
$config['route']['default']['method'] = 'index';
$config['route']['notFound']['module'] = '';
$config['route']['notFound']['controller'] = '';
//$config['route']['redirect'] = 'index';

/* 
==========================
Security
==========================
*/
$config['security']['cleanInput'] = true;

