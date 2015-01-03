<?php
namespace Controllers;

use Entities\Pessoa;
use Mvc\Controller;

class IndexController extends Controller{

    public function Index(){
        $model = new Pessoa();

        $this->View(null,$model);
    }

    public function Index_post(Pessoa $model, $arquivo = null){

        $this->View(null,$model);

    }

}