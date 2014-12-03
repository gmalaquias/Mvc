<?php
/**
 * Created by PhpStorm.
 * User: Gabriel
 * Date: 23/11/2014
 * Time: 01:48
 */

/**
 * DEFINIÇÃO DE CONSTANTES PARA URL
 */
define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', 'http://');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);


define('DS', DIRECTORY_SEPARATOR);
define('STATIC_URL', URL . 'site/util');
define('IMG_URL',URL.'util/img');

define('FOLDER_SRC','Application');

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('PATH_CONTROLLER', ROOT . FOLDER_SRC . DS . 'Controllers' . DS);
define('PATH_VIEWS', ROOT . FOLDER_SRC . DS . 'Views' . DS);
define('PATH_MODELS', ROOT . FOLDER_SRC . DS . 'Models' . DS);
define('PATH_AREA', ROOT . FOLDER_SRC . DS . 'Areas' . DS);



define('NAMESPACE_CONTROLLER', 'Controllers');
define('NAMESPACE_MODELS', 'Models');
define('NAMESPACE_AREAS', 'Areas');

/**
 * VARIAVEL DE TIMESTAMP PARA PADRÃO DE ATRIBUTOS
 */
define("CURRENT_TIMESTAMP", date('Y-m-d H:i:s'));

/**
 * DEFINIÇÂO DAS VARIAVEIS DE CONEXÂO COM O BD
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'alcatraz');
define('DB_USER', 'root');
define('DB_PASS', '');


/**
 * PREFIX PARA ADICIONAR NA ACTION QUANDO EXISTE POST NA TELA
 */
define("PREFIX_POST", "_post");