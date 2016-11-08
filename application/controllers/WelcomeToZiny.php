<?php
namespace Controller;

use Ziny;
use System\Controller;

class WelcomeToZiny extends Controller
{
    public function actionIndex()
    {
        echo 'Hello, welcome to Ziny!!!';
    }
    
    public function actionSayHello()
    {
        echo 'Say hello from another method';
    }
}