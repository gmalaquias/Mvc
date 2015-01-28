<?php

$time = microtime(1);
$mem = memory_get_usage();
echo dirname(__DIR__);

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'config.php';
require_once VENDOR . 'autoload.php';


header('Content-Type: text/html; charset=utf-8');

try {
    \Mvc\Router::run();
}catch (\Exception $e){
   echo $e;
   //\Mvc\Layout::render($e->getMessage(),'500'); TODO: Colocar redirect
}


echo '<br>';
echo '<br>';
echo '<br>';
echo 'Tempo: ', (microtime(1) - $time), "s\n";
echo 'Memória: ', (memory_get_usage() - $mem) / (1024 * 1024) . " Mb";
