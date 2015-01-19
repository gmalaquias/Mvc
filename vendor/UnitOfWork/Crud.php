<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 05/01/2015
 * Time: 09:06
 */

namespace UnitOfWork;


class Crud {

    private $type;

    function __construct($type){
        $this->type = $type;
    }

    function Get($where, $persist){
        $query = "SELECT * FROM ".$this->type . ($where != null ? " WHERE ".$where : "");
        return new Select($this->type,$query,$persist);
    }

}