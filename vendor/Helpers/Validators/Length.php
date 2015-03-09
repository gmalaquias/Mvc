<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 16/12/2014
 * Time: 11:55
 */

namespace Helpers\Validators;


use Helpers\ModelState;
use Helpers\Validation;

abstract class Length implements iValidator
{

    public static function isValid(Attributes $object)
    {
        $explode = explode(',', $object->_arg);
        if (count($explode) == 2) {
            $min = $explode[0];
            $max = $explode[1];
        } else {
            $max = $object->_arg;
            $min = 0;
        }

        if (!Validation::Lenght($object->_value, $max, $min) && ($object->_required || Validation::Required($object->_value)))
            ModelState::addError("O campo " . $object->_displayName . " deve conter " . ($min > 0 ? "no mínimo " . $min . " e " : "") . "no máximo " . $max . " caracteres.");
    }
} 