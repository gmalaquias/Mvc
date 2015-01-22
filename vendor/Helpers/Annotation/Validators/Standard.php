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

abstract class Standard implements iValidator {

    public static function isValid(Attributes $object){
        $name = $object->_name;

        $object->_model->$name = trim($object->_model->$name );

        if(!array_key_exists("AllowHtml", $object->_allOptions))
            $object->_model->$name = trim(strip_tags($object->_model->$name ));
    }
} 