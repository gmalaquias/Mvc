<?php
/**
 * Created by PhpStorm.
 * User: Gabriel
 * Date: 10/12/2014
 * Time: 22:47
 */

namespace Mvc;


class MvcException extends \Exception{
    public function __construct($msg,$code = 0){
        parent::__construct($msg,$code);
    }
} 