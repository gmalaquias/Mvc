<?php

/**
 * Classe para trabalhar com dados de sess�o
 *
 * @author TreinaWeb
 * @access public
 */

namespace Helpers;

class Session{

    /**
     * Inicializa a sess�o
     * @access public
     * @return void
     */

    public static function inicializar(){
        if(!isset($_SESSION)){
            session_start();
            session_regenerate_id();
        }
    }

    /**
     * Grava uma informa��o na sess�o
     * @access public
     * @param String $key
     * @param String $value
     * @return void
     */

    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    /**
     * Retorna um dado da sess�o
     * @access public
     * @param String $key
     * @return String
     */

    public static function get($key){

        if ( isset($_SESSION[$key]) ){
            return $_SESSION[$key];
        }
    }

    /**
     * Deleta um dado da sess�o
     * @access public
     * @param String $key
     * @return void
     */

    public static function delete($key){
        unset($_SESSION[$key]);
    }

    /**
     * Destr�i todos os dados da sess�o
     * @access public
     * @return void
     */

    public static function destroy(){
        session_destroy();
        unset($_SESSION);
    }
}