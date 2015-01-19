<?php
namespace Controllers;

use Entities\Anotacao;
use Entities\Pessoa;
use Helpers\ClassGenerator\ClassGenerator;
use Helpers\EmailHelper;
use Helpers\ModelState;
use Mvc\Controller;
use Mvc\MvcException;
use UnitOfWork\UnitOfWork;

class IndexController extends Controller{

    public function Index(){
        $model = new Pessoa();


        $model->Nome = "Teste Rollback";
        $unitof = new UnitOfWork();
        $unitof->Insert($model);
        $unitof->Save();


        $this->View(null,$model);
    }

    public function Index_post(Pessoa $model, $arquivo = null){
        try {
            if(ModelState::isValid()) {
                $unitof = new UnitOfWork();
                $unitof->Insert($model);
                $unitof->Save();

                echo "Salvo";
            }
        }catch (\Exception $e){
            echo $e;
        }

        $this->View(null,$model);
    }

}