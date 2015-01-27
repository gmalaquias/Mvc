<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 27/01/2015
 * Time: 11:47
 */

namespace Helpers\ArrayHelper;



use Helpers\StringHelper;

class ArrayHelper {

    private $array = array();

    private $type = null;

    public function __construct(array $array = array()){
        foreach($array as $element)
            $this->Add($element);
    }

    public function Add($element){
        if($this->setType($element)) {

            $this->array[] = $element;

            return $this;
        }
    }

    public function Clear(){
        $this->array = array();
    }

    public function Remove($value){
        $array = $this->array;
        foreach ($array as $key => $element) {
            if($element === $value)
                unset($this->array[$key]);
        }

        $this->Reorganize();
    }

    public function RemoveAt($index){
        if(isset($this->array[$index]))
            unset($this->array[$index]);

        $this->Reorganize();
    }

    public function Where($where){
        $array = $this->array;
        $new = new ArrayHelper();

        foreach($array as $key => $element){
            if($where($element, $key))
                $new->Add($element);
        }

        return $new;
    }

    public function Fist(){
        return ($m = array_shift($this->array)) ? $m : null;
    }

    public function getType(){
        return $this->type;
    }

    private function setType($element){
        if(is_object($element) && ($this->type == get_class($element) || count($this->array) == 0)) {
            $this->type = get_class($element);
            return true;
        }

        throw new \Exception("Tipo de objeto inválido");
    }

    public function getArray(){
        return $this->array;
    }

    public function Reorganize(){
        $this->array = array_values($this->array);
    }

    public function for_each($for){
        $array = $this->array;
        foreach($array as $key => $element)
            $for($key,$element);

        return $this;
    }
}