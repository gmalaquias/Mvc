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
    private static $layout;

    private static $content;

    private static $title = 'Page';

    private static $description = '';

    private static $favicon;

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

    /**
     * @return string
     */
    public static function getTitle()
    {
        if(PREFIX_TITLE != '')
            return PREFIX_TITLE . ' - ' . self::$title;
        return self::$title;
    }

    /**
     * @param string $title
     */
    public static function setTitle($title)
    {
        self::$title = $title;
    }

    /**
     * @return string
     */
    public static function getDescription()
    {
        return self::$description;
    }

    /**
     * @param string $description
     */
    public static function setDescription($description)
    {
        self::$description = $description;
    }

    /**
     * @return mixed
     */
    public static function getFavicon()
    {
        return self::$favicon;
    }

    /**
     * @param mixed $favicon
     */
    public static function setFavicon($favicon)
    {
        self::$favicon = $favicon;
    }

    /**
     * @return mixed
     */
    public static function getContent()
    {
        return self::$content;
    }

    /**
     * @param mixed $content
     */
    public static function setContent($content)
    {
        self::$content = $content;
    }

}
