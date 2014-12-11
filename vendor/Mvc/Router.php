<?php

/**
 * Roteador. Responsável por incluir o controlador e executar o seu respectivo método informado
 *
 * @author Gabriel Malaquias
 * @access public
 */

namespace Mvc;

/**
 * Class Router
 * @package Mvc
 */
class Router
{
    /**
     * Método responsável por obter o nome do controlador e do método e executá-los.
     * @access public
     * @return void
     */

    public static function run()
    {
        //pega o controller na URL
        Request::run();

        $controller = Request::getCompleteController();

        //verifica se o controlador existe
        if (file_exists(PATH_CONTROLLER . $controller . '.php')) {
            //instancia o controlador
            $controlador = NAMESPACE_CONTROLLER . "\\" .$controller;
            $controlador = new $controlador();

            //pega o metodo da URL
            $action = Request::getAction();
            //Transforma o resto da URL em Array
            $args = (array)Request::getArgs();

            //verifica se o metodo existe no controlador
            $post = self::VerificaMetodo($controlador,$action);

        } else {
            
            Request::InverseArea();
            $area = Request::getArea();
            $controller = Request::getCompleteController();

            if (file_exists(PATH_AREA . $area . DS . 'Controllers' . DS . $controller . '.php')) {
                //instancia o controlador
                $controlador = NAMESPACE_AREAS . "\\" . $area . "\\Controllers\\" . $controller;
                $controlador = new $controlador();

                //pega o metodo da URL
                $action = Request::getAction();
                //Transforma o resto da URL em Array
                $args = (array)Request::getArgs();

                $post = self::VerificaMetodo($controlador, $action);
            }else{
                self::error("Nada encontrado");
            }
        }

        call_user_func_array(array($controlador, $action.$post), $args);


        //retorno para ser usado no layout
//        $return = array();
//        $return['title'] = $controlador->title;
//        $return['layout'] = $controlador->layout;
//
//        //retorna
//        return $return;
    }

    /**
     * @param $controller
     * @param $action
     * @return string
     * @throws \Exception
     */
    public static function VerificaMetodo($controller, $action)
    {
        $addPost = "";
        if (isset($_POST) and count($_POST) > 0)
            $addPost = PREFIX_POST;

        if(!method_exists($controller, $action.$addPost)) {
            $addPost = "";
            if (!method_exists($controller, $action)) {
                self::error("Erro");
            }
        }

        return $addPost;
    }

    /**
     * @param $msg
     * @throws \Exception
     */
    protected static function error($msg)
    {
        throw new MvcException($msg);
    }
}