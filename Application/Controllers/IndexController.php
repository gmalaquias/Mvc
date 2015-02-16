<?php
namespace Controllers;

use Entities\Anotacao;
use Entities\Pessoa;
use Helpers\ClassGenerator\ClassGenerator;
use Helpers\Cookie;
use Helpers\DateTime;
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
        $cookie = new Cookie('Alcatraz');
        $cookie->set("Nome","inome");

        $uni = new UnitOfWork();
        var_dump($uni->Get("Anotacao")
            ->Join($uni->Get("Pessoa") ,"A.PessoaId", "P.PessoaId")
                ->Select("P.PessoaId")
                ->Distinct()
                ->ToList()
        );

    }

    public function Index_post(Pessoa $model, $arquivo = null)
    {
        try {
            if (ModelState::isValid()) {

                $unitof = new UnitOfWork();
                $unitof->Insert($model);
                $unitof->Save();
            }
        } catch (\Exception $e) {
           echo $e;
        }

        $this->View(null, $model);
    }
}