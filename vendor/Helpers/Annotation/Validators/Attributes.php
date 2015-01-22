<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 16/12/2014
 * Time: 11:51
 */

namespace Helpers\Annotation\Validators;


class Attributes {

    /*
     * Nome do campo
     */
    public $_name;

    /**
     * DisplayName do campo
     */
    public $_displayName;

    /**
     * Valor do campo
     */
    public $_value;

    /**
     * Anotação selecionada
     */
    public $_annnotation;

    /**
     * Valor da Anotação
     */
    public $_arg;

    /**
     * Array do opções da anotação
     */
    public $_options;

    /**
     * Classe que vem o campo, pode ser usado para alterar seu valor na classe atual
     */
    public $_model;

    /**
     * Contem todas as anotações para o campo passado
     */
    public $_allOptions;

    public function __construct($name, $displayName, $value, $annotation, $arg, $options, $model, $allOptions ){
        $this->_name        = $name;
        $this->_displayName = $displayName;
        $this->_value       = $value;
        $this->_annnotation = $annotation;
        $this->_arg         = $arg;
        $this->_options     = $options;
        $this->_model       = $model;
        $this->_allOptions   = $allOptions;

        $this->callFunction();
    }

    private function callFunction(){
        if(file_exists(VALIDATORS_PATH . $this->_annnotation . '.php')){
            $class = NAMESPACE_VALIDATORS . $this->_annnotation;
            call_user_func_array(array( $class , "isValid"), array($this));
        }
    }

} 