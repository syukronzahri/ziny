<?php
namespace Controller\SomeModule;

use Ziny;
use System\Controller;
use System\View;

class SomeController extends Controller
{
    public function actionIndex()
    {
        echo "Hello, welcome to SomeController! It's inside SomeModule!";
    }
    
    public function actionSayHello()
    {
        echo 'Hello from SomeController inside SomeModule';
    }

    public function actionLoadView()
    {        
        $data = array(
            'table' => array(
                array('nama' => 'Syukron Zahri', 'kelamin' => 'Laki-Laki'),
                array('nama' => 'Lusi Maerinda', 'kelamin' => 'Perempuan'),
                array('nama' => 'Auliya Rahman', 'kelamin' => 'Laki-Laki'),
                array('nama' => 'Elza Oktaviana', 'kelamin' => 'Perempuan'),
            )
        );
        $this->view->render('index', $data);
    }
}