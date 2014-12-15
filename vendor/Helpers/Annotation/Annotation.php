<?php
/**
 * Criado Por: Gabriel Malaquias
 * github: github.com/gmalaquias
 * Date: 05/12/2014
 * Time: 20:26
 */

namespace Helpers\Annotation;

/**
 * Class Annotation
 * @package Helpers\Annotation
 */
class Annotation {

    /**
     * @type: ReflectionClass()
     */
    private $_reflection;

    /**
     * @type: Generic
     * @description: receives the class used to get annotations
     */
    private $_class;

    /**
     * @type: array
     * @description: receives all the notes read the attributes of the class
     */
    private $_annotations = array();

    /**
     * @type: string
     * @description: regex used to read the code blocks
     */
    private $_regex = "/@(.*):(.*)|@(.*)/mi";

    /**
     * @type: array
     * @description: receives type annotations
     */
    private $_attributes = array("Required" => array(),
                                 "NotMapped" => array(),
                                 "Range" => array(),
                                 "Email" => array(),
                                 "Date" =>  array(),
        "DateTime" => array()
                            );

    /**
     * @param: $class Class
     * @throws: AnnotationException
     */
    function __construct($class){
        $this->getClass($class);

        $this->_reflection = new \ReflectionClass($this->_class);

        $this->getAllAnnotations();
    }

    /**
     * @description: passes attributes for class attribute by calling the method that reads the blocks
     */
    private function getAllAnnotations(){
        $properties = $this->_reflection->getProperties();
        foreach ($properties as $l) {
            $this->getAnnotationByAttribute($l->name);
        }
    }

    /**
     * @param: $attr Attribute for read
     * @description: handle attribute of the comment block passes the parameter is the instantiated class in the constructor
     */
    private function getAnnotationByAttribute($attr){
        $method = new \ReflectionProperty($this->_class, $attr);

        preg_match_all($this->_regex, $method->getDocComment(),$out, PREG_SET_ORDER);
        #var_dump($this->_attributes);
        if(is_array($out)) :
            $count = count($out);

            $this->_annotations[$attr] = array();

            for ($i = 0; $i < $count; ++$i):
                $this->setAnnotation($out[$i], $attr);
            endfor;
        endif;
    }

    /**
    * @param array $array
    * @param $attr
     */
    private function setAnnotation(array $array, $attr){
        if($array[1] == '')
            $annotation = ucfirst(trim(preg_replace('/\s\s+/', '', $array[3])));
        else
            $annotation = ucfirst(trim(preg_replace('/\s\s+/', '', $array[1])));
        #var_dump($annotation);
        if(array_key_exists($annotation, $this->_attributes))
            $this->_annotations[$attr][$annotation] = trim($array[2] == '' ? 'true' : str_replace(";", "", $array[2]));
    }

    /**
     * @param: $class
     * @return: mixed
     * @throws: AnnotationException
     * @description: Fills the attribute class as the type of last variable and checks whether its use is possible
     */
    private function getClass($class){
        if(is_object($class))
            return $this->_class = &$class;

        if(class_exists($class))
            return $this->_class = new $class();

        throw new AnnotationException("AnnotationError: Esta classe não existe.", 1);
    }

    /**
    * @return array
    */
    public function getAnnotations(){
        return $this->_annotations;
    }


    /**
    * @return array
    */
    public function getAttributes(){
        return $this->_attributes;
    }

    /**
    * @param $attr
    * @return null
    */
    public function getAnnotationsByAttribute($attr){
        $annotations = $this->getAnnotations();
        if(isset($annotations[$attr]))
            return $annotations[$attr];

        return null;
    }
} 