<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 05/01/2015
 * Time: 15:16
 */

namespace UnitOfWork;


class UnitOfWorkException extends \Exception {
    public function __construct($msg,$code = 0){
        parent::__construct($msg,$code);
    }
} 