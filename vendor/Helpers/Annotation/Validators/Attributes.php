<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 16/12/2014
 * Time: 11:51
 */

namespace Helpers\Annotation\Validators;


class Attributes {

    public $_name;

    public $_value;

    public $_annnotation;

    public $_arg;

    public $_options;

    public function __construct($name, $value, $annotation, $arg, $options){
        $this->_name        = $name;
        $this->_value       = $value;
        $this->_annnotation = $annotation;
        $this->_arg         = $arg;
        $this->_options     = $options;

        $this->callFunction();
    }

    private function callFunction(){
        if(file_exists(VALIDATORS_PATH . $this->_annnotation . '.php')){
            $class = NAMESPACE_VALIDATORS . $this->_annnotation;
            call_user_func_array(array( $class , "isValid"), array($this));
        }
    }

} 