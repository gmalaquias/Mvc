<?php
/**
 * Created by PhpStorm.
 * User: Gabriel
 * Date: 23/11/2014
 * Time: 01:39
 */

$time = microtime(1);
$mem = memory_get_usage();

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';


header('Content-Type: text/html; charset=utf-8');



try {
    $a = new \Mvc\Router();
    $a->run();
}catch (\Exception $e){
    echo $e->getMessage();
}


echo '<br>';
echo '<br>';
echo '<br>';
echo 'Tempo: ', (microtime(1) - $time), "s\n";
echo 'Memória: ', (memory_get_usage() - $mem) / (1024 * 1024) . " Mb";
