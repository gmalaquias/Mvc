<?php
/**
 * Created by PhpStorm.
 * User: Gabriel
 * Date: 23/01/2015
 * Time: 22:19
 */

namespace Mvc;


use Helpers\StringHelper;

class Url {

    static function RedirectToAction($action){
        $controller = Request::getController();
        $area = Request::getArea();

        self::RedirectTo($controller,$action,$area);
    }

    static function RedirectExtern($url){
        if(StringHelper::Contains($url,'http:') || StringHelper::Contains($url,'https:'))
            self::Redirect($url);
        else
            self::Redirect('http://' . $url);
    }

    static function RedirectTo($action,$controller=null,$area = null){
        $url = self::getUrl($action,$controller,$area);

        self::Redirect($url);
    }

    static function getUrl($action,$controller = null,$area = null){
        if($controller == null)
            $controller = Request::getController();
        if($area == null && $controller != CONTROLLER_404)
            $area = Request::getArea();

        $url = URL;
        if($area != null)
            $url .= $area . "/";

        $url .= (ucfirst($controller) == ucfirst(DEFAULT_CONTROLLER_ABV) && ucfirst($action) == ucfirst(DEFAULT_VIEW)
                ? ""
                : ucfirst($controller) . "/"
            ) .
            (ucfirst($action) == ucfirst(DEFAULT_VIEW)
                ? ""
                : ucfirst($action)
            );

        return $url;
    }

    private static function Redirect($url){
        header('Location: ' . $url);
    }





} 