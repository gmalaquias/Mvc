<?php

$time = microtime(1);
$mem = memory_get_usage();

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'config.php';
require_once VENDOR . 'autoload.php';

try {
    \Mvc\Router::run();
}catch (\Exception $e){
   echo $e;
}

echo '<br>';
echo '<br>';
echo '<br>';
echo 'Tempo: ', (microtime(1) - $time), "s\n";
echo 'Memória: ', (memory_get_usage() - $mem) / (1024 * 1024) . " Mb";
