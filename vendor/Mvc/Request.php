<?php

/**
 * Classe responsável por obter os segmentos da URL informada
 *
 * @author Gabriel Malaquias
 * @access public
 */
namespace Mvc;

class Request
{
    private static $_area = null;
    private static $_controller = "IndexController";
    private static $_action = "Index";
    private static $_args = array();

    /**
     * @access public
     * @return void
     */
    public static function run()
    {
        // Algum controlador foi informado na URL? se n�o foi, mant�m que o controlador � o 'index'.
        if( !isset($_GET["url"]) ) return false;

        // Explode os segmentos da URL e os armazena em um Array
        $segmentos = explode('/',$_GET["url"]);
        // Se o controlador foi realmente definido, retorna o nome dele.
        self::$_controller = (($c = array_shift($segmentos)) ? $c : 'Index') . 'Controller';
        // Se um m�todo foi realmente requisitado, retorna o nome dele.
        self::$_action = ($m = array_shift($segmentos)) ? $m : 'Index';

        // Se argumentos adicionais foram definidos, os retorna em Array.
        self::$_args = (count($segmentos) > 0) ? $segmentos : array();
    }

    public static function InverseArea(){
        if( !isset($_GET["url"]) ) return false;

        // Explode os segmentos da URL e os armazena em um Array
        $segmentos = explode('/',$_GET["url"]);

        self::$_area = ($m = array_shift($segmentos)) ? $m : 'Index';

        self::$_controller = (($c = array_shift($segmentos)) ? $c : 'Index') . 'Controller';

        self::$_action = ($m = array_shift($segmentos)) ? $m : 'Index';

        self::$_args = (count($segmentos) > 0) ? $segmentos : array();
    }
    
    public static function getController(){
        return str_replace('Controller', "", self::$_controller);
    }
    
    public static function getArea(){
        return self::$_area;
    }
    
    public static function getAction(){
        return self::$_action;
    }
    
    public static function getArgs(){
        return self::$_args;
    }
    
    public static function getCompleteController(){
        return self::$_controller;
    }
    

}