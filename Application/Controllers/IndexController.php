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
        $model = new Pessoa();
        $this->View(null,$model);
    }

    public function Index_post(Pessoa $model, $arquivo = null){
        $this->View(null,$model);

        var_dump($model);

        echo 'Arquivo';
        var_dump($arquivo);
    }

}