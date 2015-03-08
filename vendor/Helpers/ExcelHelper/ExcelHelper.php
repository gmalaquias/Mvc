<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 16/01/2015
 * Time: 09:17
 */

namespace Helpers\ExcelHelper;


use Mvc\Layout;

class ExcelHelper {

public static function Export($content, $arquivo = "file"){
        // Determina que o arquivo é uma planilha do Excel
        header("Content-type: application/vnd.ms-excel");

        // Força o download do arquivo
        header("Content-type: application/force-download");

        // Seta o nome do arquivo
        header("Content-Disposition: attachment; filename=".$arquivo.".xls");

        header("Pragma: no-cache");

        //seta o layout como nulo
        Layout::setLayout(null);
        // Imprime o conteúdo da nossa tabela no arquivo que será gerado
        echo $content;
    }
} 