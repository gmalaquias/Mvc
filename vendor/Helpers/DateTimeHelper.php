<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 04/02/2015
 * Time: 09:17
 */

namespace Helpers;


class DateTimeHelper {

    CONST format = "d/m/Y H:i:s";

    public static function now(){
        return self::getdate(self::format, "now");
    }

    public static function convertBr($date, $format = self::format){
        return self::getdate($format, $date);
    }

    private static function getDate($format, $date){
        return date($format, strtotime($date));
    }

    public static function addDays($days, $date = null){
        if($date == null)
            $date = self::now();

        return self::getDate(self::format , ($days > 0 ? '+'.$days : $days) . ' days', strtotime($date));
    }



} 