<?php
/**
 * Created by PhpStorm.
 * User: Gabriel
 * Date: 02/01/2015
 * Time: 23:53
 */

namespace Helpers;


class StringHelper {

    public static function Contains($string, $contains){
        return (strpos($string, $contains) !== FALSE);
    }

    public static function RemoveAcentos($string){
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!´@#$%&*()_-+={[}]/?;:.,\\\'<>º^';
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($a), $b);
        $string = strip_tags(trim($string));
        $string = str_replace(" ","-",$string);

        return strtolower(utf8_encode($string));
    }
} 