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

abstract class Range implements iValidator {

    public static function isValid(Attributes $object){
        $explode = explode(',',$object->_arg);
        if(count($explode) == 2) {
            $min = $explode[0];
            $max = $explode[1];
        }else{
            $max = $object->_arg;
            $min =0;
        }


            if(!Validation::Number($object->_value))
                return ModelState::addError("O campo " . $object->_displayName . " deve ser um número.");

            if(!Validation::Range($object->_value,$max,$min))
                ModelState::addError("O campo " . $object->_displayName . " deve estar dentro do intervalo de " . $min . " e " . $max . "." );
    }
} 