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
    public $layout;
    public $conteudo;
    public $title = 'Innet';
    
    public function __get($name){
        return isset($this->$name) ? $this->$name : null;
    }
    
    public function __set($name, $value){
        $this->$name = $value;
    }

    public function render($conteudo = null, $arquivo = null){
        $this->conteudo = $conteudo;
        $this->getArquivo($arquivo);


        if(!file_exists($arquivo) || $arquivo == null)
            return $conteudo;

            ob_start();
            include $arquivo;
            $render = ob_get_clean();
            return $render;
    }

    private function getArquivo(&$arquivo){
        $arquivo = STATIC_PATH . DS . 'layouts'. DIRECTORY_SEPARATOR . $arquivo . '.php';
    }
    
}
