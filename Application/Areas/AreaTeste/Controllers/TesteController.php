<?php
/**
 * Created by PhpStorm.
 * User: Gabriel
 * Date: 23/11/2014
 * Time: 02:46
 */

namespace Areas\AreaTeste\Controllers;

use Mvc\Controller;
use Mvc\Url;

class TesteController extends Controller{

    public function Index(){
        echo 'Agora';
        $this->View();
    }

    public function Teste(){
        echo 'ok';
    }


} 