<?php
namespace Controllers;

use Entities\Pessoa;
use Helpers\ModelState;
use Mvc\Controller;

class IndexController extends Controller{

    public function Index(){
        $model = new Pessoa();
        //ModelState::RemoveNotMapped($model);

        var_dump($model);

        $model->PessoaId = 1;
        $model->Nome = "ajsgdasd";


        $this->View(null,$model);
    }

    public function Index_post(Pessoa $model, $arquivo = null){
        $this->View(null,$model);
    }

}