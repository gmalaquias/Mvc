<?php

/**
 * Layout short summary.
 *
 * Layout description.
 *
 * @version 1.0
 * @author Gabriel
 */
namespace Mvc;

class Layout
{
    public static $layout;

    public static $content;

    public static $title = 'Mvc';

    public static $description = '';

    public static $favicon;

    public static function render($content = null, $arquivo = 'basic'){
        self::$content = $content;
        self::getArquivo($arquivo);

        if(!file_exists($arquivo) || $arquivo == null)
            echo $content;
        else {
            ob_start();
            include $arquivo;
            $render = ob_get_clean();
            echo $render;
        }
    }

    private static function getArquivo(&$arquivo){
        $arquivo = PATH_LAYOUT . $arquivo . '.php';
    }
    
}
