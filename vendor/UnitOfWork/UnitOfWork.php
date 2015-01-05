<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 05/01/2015
 * Time: 09:06
 */

namespace UnitOfWork;


class UnitOfWork{

    function Repository($type){
        $repository = new Repository($type);
        return $repository;
    }

} 