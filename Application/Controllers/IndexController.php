<?php
namespace Controllers;

use Entities\Pessoa;
use Helpers\Annotation\Annotation;
use Helpers\ModelState;
use Helpers\Session;
use Mvc\Controller;

class IndexController extends Controller{

    public function Index(){
        $model = new Pessoa();
        $this->View(null,$model);
    }

    public function Index_post(Pessoa $model){
        $this->View(null,$model);
    }

}