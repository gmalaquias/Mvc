<?php
/**
 * User: gabriel.malaquias
 * Date: 10/12/2014
 * Time: 15:06
 */

namespace Helpers;

use Helpers\Annotation\Annotation;
use Helpers\Annotation\Validators\Attributes;

class ModelState
{

    public static $errors = array();

    public static function addError($erro)
    {
        array_push(self::$errors, $erro);
    }

    public static function getErrors()
    {
        return self::$errors;
    }

    public static function isValid()
    {
        if (count(self::$errors) == 0)
            return true;

        return false;
    }

    public static function clear()
    {
        self::$errors = array();
    }

    public static function ModelTreatment($model)
    {
        $annotation = new Annotation($model);
        $get = $annotation->getAnnotations();

        foreach ($get as $campo => $data):
            if (array_key_exists("NotMapped", $data))
                unset($model->$campo);
            else{
                if (array_key_exists("Type", $data) && StringHelper::Contains($data["Type"], "tinyint"))
                    $model->$campo = ($model->$campo != "true" && $model->$campo != "1") ? "0" : "1";
            }
        endforeach;
    }

    public static function GetPrimary($model)
    {
        $annotation = new Annotation($model);
        $get = $annotation->getAnnotations();

        foreach ($get as $campo => $data):
            if (array_key_exists("PrimaryKey", $data))
                return $campo;
        endforeach;

        return null;
    }

    public static function GetVirtuals($model)
    {
        $annotation = new Annotation($model);
        $get = $annotation->getAnnotations();

        $return = array();

        foreach ($get as $campo => $data):
            if (array_key_exists("Virtual", $data))
                $return[$data["Name"]] = array("Type" => $data["Type"],
                                  "Fk" => $data["Fk"]);

        endforeach;

        return $return;
    }

    public static function ConvertDateBr($model)
    {
        $annotation = new Annotation($model);
        $get = $annotation->getAnnotations();

        foreach ($get as $campo => $data):
            if (array_key_exists("Date", $data)) {
                $date = date_parse_from_format('d-m-Y', $model->$campo);
                $model->$campo = date("Y-m-d", mktime($date['hour'], $date['minute'], $date['second'], $date['month'], $date['day'], $date['year']));
            } else if (array_key_exists("DateTime", $data)) {
                $date = date_parse_from_format('d-m-Y H:i:s', $model->$campo);
                $model->$campo = date("Y-m-d H:i:s", mktime($date['hour'], $date['minute'], $date['second'], $date['month'], $date['day'], $date['year']));
            }
        endforeach;
    }

    public static function TryValidationModel($model)
    {
        $classAnnotations = new Annotation($model);
        $attributes = $classAnnotations->getAttributes();
        $annotation = $classAnnotations->getAnnotations();

        foreach ($annotation as $campo => $options):
            //var_dump($options);
            foreach ($options as $attr => $valor):
                if (!array_key_exists("getFunction", $attributes[$attr]) || $attributes[$attr]["getFunction"] == true)
                    $parameter = new Attributes($campo,
                        $classAnnotations->getName($campo),
                        $model->$campo,
                        $attr,
                        $valor, $attributes[$attr],
                        $model,
                        $options
                    );
            endforeach;

            //Chame um metodo default para todos os campos
            if (USE_STANDARD_VALIDATOR)
                $parameter = new Attributes($campo,
                    $classAnnotations->getName($campo),
                    $model->$campo,
                    "Standard",
                    $valor, $attributes[$attr],
                    $model,
                    $options
                );

        endforeach;
    }

} 