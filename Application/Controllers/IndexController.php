<?php
namespace Controllers;

use Entities\Pessoa;
use Helpers\ModelState;
use Mvc\Controller;
use UnitOfWork\UnitOfWork;

class IndexController extends Controller{

    public function Index(){
       $model = new Pessoa();
       //ModelState::RemoveNotMapped($model);

       $Unitof = new UnitOfWork();

       //var_dump($Unitof->Repository('Pessoa')->Get('PessoaId = 2')->FirstOrDefault())

       $this->View(null,$model);
    }

    public function Index_post(Pessoa $model, $arquivo = null){
        echo 'post';
        $this->View(null,$model);
    }

}