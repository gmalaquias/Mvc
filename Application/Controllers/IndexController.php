<?php
/**
 * Created by PhpStorm.
 * User: Gabriel
 * Date: 23/11/2014
 * Time: 02:46
 */

namespace Controllers;

use Mvc\Controller;

class IndexController extends Controller{

    public function Index(){
        throw new \Exception('ad');
    }
    
    public function Teste(){
        $this->Model();
    }

} 