<?php
/**
 * User: gabriel.malaquias
 * Date: 10/12/2014
 * Time: 15:06
 */

namespace Helpers;

use Helpers\Annotation\Annotation;

class ModelState {

    public static $errors = array();


    public static function addError($erro){
        array_push(self::$errors, $erro);
    }

    public static function getErrors(){
        return self::$errors;
    }

    public static function isValid(){
        if(count(self::$errors) == 0)
            return true;

        return false;
    }

    public static function clear(){
        self::$errors = array();
    }

    public static function RemoveNotMapped($model){
        $annotation = new Annotation($model);
        $get = $annotation->getAnnotations();

        foreach ($get as $campo=>$data):
            if (array_key_exists("NotMapped", $data))
                unset($model->$campo);
        endforeach;
    }

    public static function TryValidationModel($model){
        $annotation = new Annotation($model);
        $get = $annotation->getAnnotations();


    }

} 