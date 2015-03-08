<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 16/12/2014
 * Time: 11:55
 */

namespace Helpers\Annotation\Validators;


use Helpers\ModelState;
use Helpers\Validation;

abstract class Date implements iValidator {

    public static function isValid(Attributes $object){
        if(!Validation::Date($object->_value))
            ModelState::addError("O campo " . $object->_displayName . " deve ser uma data.");
    }

} 