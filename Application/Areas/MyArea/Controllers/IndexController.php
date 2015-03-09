<?php
/**
 * Created by PhpStorm.
 * User: Gabriel
 * Date: 23/11/2014
 * Time: 02:46
 */

namespace Areas\AreaTeste\Controllers;

use Mvc\Controller;

class IndexController extends Controller{
    public function Index(){
        $this->View();
    }
}