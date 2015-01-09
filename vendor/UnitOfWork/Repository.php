<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 05/01/2015
 * Time: 10:22
 */

namespace UnitOfWork;


use Helpers\ModelState;

class Repository {

    private $type;

    function __construct($type){
        $this->type = $type;
    }

    function Get($where = null, $persist = null){
        $get = new Crud($this->type);
        return $get->Get($where,$persist);
    }

    function GetById($id){
        $newClass = 'Entities\\' . $this->type;
        if(class_exists ($newClass)) {
            $class = new $newClass();
            $primaryKey = ModelState::GetPrimary($class);
            if ($primaryKey != null)
                return $this->Get($primaryKey . '=' . $id)->FirstOrDefault();

            return null;
        }

        throw new UnitOfWorkException("Classe {$newClass} não encontrada", 1);
    }

    function ExecuteQuery(){

    }
} 