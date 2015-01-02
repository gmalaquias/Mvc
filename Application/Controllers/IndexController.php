<?php
namespace Controllers;

use Entities\Pessoa;
use Helpers\Annotation\Annotation;
use Helpers\ClassGenerator\ClassGenerator;
use Helpers\ModelState;
use Helpers\Session;
use Mvc\Controller;

class IndexController extends Controller{

    public function Index(){
        $model = new \stdClass();
        $this->View(null,$model);

        var_dump($_SESSION);
    }

    public function Index_post(Pessoa $model){

        $this->View(null,$model);
    }

}