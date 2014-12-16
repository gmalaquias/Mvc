<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 16/12/2014
 * Time: 11:55
 */

namespace Helpers\Annotation\Validators;


use Helpers\ModelState;

abstract class Required implements iValidator {

    public static function isValid(Attributes $object){
        if(empty($object->_value))
            ModelState::addError("O campo " . $object->_name . " é obrigatório.");
    }

} 