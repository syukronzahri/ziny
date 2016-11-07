<?php
define('ENVIRONMENT', 'development');

switch (ENVIRONMENT) {
    case 'development':
        error_reporting(E_ALL);
        break;
    case 'testing':
        error_reporting(E_ALL & ~E_STRICT);
        break;
    case 'production':
        error_reporting(0);
        break;
    default:
        exit('Setting is not correct');
}

define('START_POINT', TRUE);

define('SERVER_NAME', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME']);
define('DOCUMENT_ROOT_PATH', str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT']));
define('BASE_PATH', dirname(__FILE__));
$basePath = explode(DIRECTORY_SEPARATOR, BASE_PATH);

define('BASE_FOLDER_NAME', end($basePath));
define('RELATIVE_BASE_PATH', trim(str_replace(DOCUMENT_ROOT_PATH, '', BASE_PATH), DIRECTORY_SEPARATOR));
define('BASE_URL', SERVER_NAME . '/' . str_replace(DIRECTORY_SEPARATOR, '/', RELATIVE_BASE_PATH));
define('RELATIVE_URL_PATH', str_replace(DIRECTORY_SEPARATOR, '/', RELATIVE_BASE_PATH));
define('SYSTEM_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'system');
define('APPLICATION_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'application');
define('CONFIG_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'config');
define('REQUEST_URL', $_SERVER['REQUEST_URI']);
define('FULL_URL', SERVER_NAME . REQUEST_URL);

spl_autoload_register(function($class)
{
    $classSegment = explode('\\', $class);

    $classRelativePath = null;
    $type = null;
    
    switch ($classSegment[0]) {
        case 'Controller':
            $classRelativePath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'controllers';
            break;
        case 'Model':
            $classRelativePath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'models';
            break;
        case 'Library':
            $classRelativePath = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'library';
            break;
        case 'System':
            $classRelativePath = SYSTEM_PATH;
            break;
        case 'Ziny':
            $classRelativePath = SYSTEM_PATH;
            $classSegment[1] = 'Ziny';
            break;
        default:
            throw new Exception("Class is not valid. Class path: {$class}");
            break;
    }
    
    $classSegment[0] = $classRelativePath;
    $classPath = implode(DIRECTORY_SEPARATOR, $classSegment) . '.php';
    
    if (file_exists($classPath)) {
        require_once($classPath);
    } else {
        throw new Exception("Could not load class {$class}");
    }
});

if (file_exists(CONFIG_PATH . '/config.php')) {
    require(CONFIG_PATH . '/config.php');
} else {
    throw new Exception("Could not load config " . DIRECTORY_SEPARATOR . " config.php file");
}

use Ziny as Ziny;
use System\Exception;

$application = new Ziny(REQUEST_URL, FULL_URL, RELATIVE_URL_PATH, SYSTEM_PATH, APPLICATION_PATH, BASE_FOLDER_NAME, RELATIVE_BASE_PATH, BASE_URL, $config);
$application->run();