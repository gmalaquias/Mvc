<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'config.php';
require_once VENDOR . 'autoload.php';

try {
    \Mvc\Router::run();
}catch (\Exception $e){
   echo $e;
}


