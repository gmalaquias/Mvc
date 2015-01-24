<?php
namespace Controllers;

use Entities\Anotacao;
use Entities\Pessoa;
use Helpers\ClassGenerator\ClassGenerator;
use Helpers\EmailHelper;
use Helpers\ModelState;
use Mvc\Controller;
use Mvc\MvcException;
use Mvc\Url;
use UnitOfWork\UnitOfWork;
use UnitOfWork\UnitOfWorkException;

class IndexController extends Controller
{
    public function Index()
    {
        $model = new Pessoa();

        $this->View(null, $model);
    }

    public function Index_post(Pessoa $model, $arquivo = null)
    {
        try {
            if (ModelState::isValid()) {
//                $unitof = new UnitOfWork();
//                $unitof->Insert($model);
//                $unitof->Save();

                echo "Salvo";
            }
        } catch (\Exception $e) {
            ModelState::addError($e->getMessage());
        }

        $this->View(null, $model);
    }
}