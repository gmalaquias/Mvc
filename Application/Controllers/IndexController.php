<?php
namespace Controllers;

use Entities\Pessoa;
use Helpers\EmailHelper;
use Helpers\ModelState;
use Mvc\Controller;
use Mvc\MvcException;
use UnitOfWork\UnitOfWork;

class IndexController extends Controller{

    public function Index(){
       $model = new Pessoa();
       //ModelState::RemoveNotMapped($model);

       $Unitof = new UnitOfWork();

       //var_dump($Unitof->Repository('Pessoa')->Get('PessoaId = 1')->FirstOrDefault());

       //throw new MvcException('asd');


       $this->View(null,$model);
    }

    public function Index_post(Pessoa $model, $arquivo = null){
        echo 'post';
        $this->View(null,$model);
    }

}