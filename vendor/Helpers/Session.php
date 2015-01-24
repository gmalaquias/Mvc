<?php

/**
 * Classe para trabalhar com dados de sessão
 *
 * @author Gabriel Malaquias
 * @access public
 */

namespace Helpers;

class Session{

    public static $session_id;

    /**
     * Inicializa a sessão
     * @access public
     * @return void
     */

    public static function start(){
        if(!isset($_SESSION)){
            session_start();
            self::$session_id = session_id();
        }
    }

    /**
     * Grava uma informação na sessão
     * @access public
     * @param String $key
     * @param String $value
     * @return void
     */

    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    /**
     * Retorna um dado da sessão
     * @access public
     * @param String $key
     * @return String
     */

    public static function get($key){

        if ( isset($_SESSION[$key]) )
            return $_SESSION[$key];

        return null;

    }

    /**
     * Deleta um dado da sessão
     * @access public
     * @param String $key
     * @return void
     */

    public static function delete($key){
        unset($_SESSION[$key]);
    }

    /**
     * Destrói todos os dados da sessão
     * @access public
     * @return void
     */

    public static function destroy(){
        session_destroy();
        unset($_SESSION);
        session_start();
        //session_regenerate_id();
    }
}