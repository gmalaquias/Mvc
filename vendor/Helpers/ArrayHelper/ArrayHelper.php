<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 27/01/2015
 * Time: 11:47
 */

namespace Helpers\ArrayHelper;

use Helpers\StringHelper;
use UnitOfWork\iSelect;

class ArrayHelper implements iSelect{

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

    public function getArray(){
        return $this->array;
    }

    public function for_each($for){
        $array = $this->array;
        foreach($array as $key => $element)
            $for($key,$element);

        return $this;
    }

    public static function getFirstElement(array $array){
        return $array[0];
    }

    private function Reorganize(){
        $this->array = array_values($this->array);
    }

    private function setType($element){
        if(is_object($element) && ($this->type == get_class($element) || count($this->array) == 0)) {
            $this->type = get_class($element);
            return true;
        }

        throw new \Exception("Tipo de objeto inválido");
    }


    //TODO::Implementar
    public function FirstOrDefault()
    {
        // TODO: Implement FirstOrDefault() method.
    }

    public function ToList()
    {
        // TODO: Implement ToList() method.
    }

    public function OrderBy($campo)
    {
        // TODO: Implement OrderBy() method.
    }

    public function OrderByDescending($campo)
    {
        // TODO: Implement OrderByDescending() method.
    }

    public function Take($take)
    {
        // TODO: Implement Take() method.
    }

    public function Skip($skip)
    {
        // TODO: Implement Skip() method.
    }

    public function Select($select, $novaClasse = null)
    {
        // TODO: Implement Select() method.
    }

    public function Join($join, $on, $on2)
    {
        // TODO: Implement Join() method.
    }

    public function LeftJoin($join, $on, $on2)
    {
        // TODO: Implement LeftJoin() method.
    }

    public function GroupBy($fields)
    {
        // TODO: Implement GroupBy() method.
    }

    public function Sum($field)
    {
        // TODO: Implement Sum() method.
    }

    public function AVG($field)
    {
        // TODO: Implement AVG() method.
    }

    public function Having($having)
    {
        // TODO: Implement Having() method.
    }

    public function Distinct()
    {
        // TODO: Implement Distinct() method.
    }

    public function Count()
    {
        // TODO: Implement Count() method.
    }
}