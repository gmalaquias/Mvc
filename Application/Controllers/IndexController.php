<?php
namespace Controllers;

use Helpers\Annotation\Annotation;
use Helpers\ModelState;
use Mvc\Controller;

class IndexController extends Controller{

    public function Index(){
        $model = new \stdClass();
        $model->nome = "teste";
        $this->View(null, $model);
    }

    /**
     * Post Exemplo
     */
    public function Index_post($model){
        $this->View(null,$model);
    }
}