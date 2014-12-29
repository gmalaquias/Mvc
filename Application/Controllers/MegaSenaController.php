<?php
namespace Controllers;

use Helpers\Annotation\Annotation;
use Helpers\ModelState;
use Mvc\Controller;

class MegaSenaController extends Controller{

    public function Index(){
        $this->View();
    }

    public function getHtml(){
        include VENDOR . 'Simple_Html_Dom' . DS . 'simple_html_dom.php';

        ini_set('max_execution_time', 0);

        $doc = new \DOMDocument();
        $doc->loadHTMLFile(PATH_VIEWS . 'MegaSena' . DS . 'Index.php');
        $a = $doc->saveHTML();

        $html = new \simple_html_dom();

        // Load HTML from a string
        $html->load($a);;

        //var_dump($html->find('.table'));

//
        for($i = 1; $i<=60;++$i){
            $a = 'n'. ($i < 10 ? "0".$i : $i);
            $$a = 0;
        }
    //1823
        $busca = $html->find('.table',0);
        for($i=1;$i<1823;$i++) {
            for ($j = 2; $j <= 7; $j++){
            @$result = $busca->children($i)->children($j)->plaintext;
                if (!empty($result)) {
                    $n = 'n' . $result;
                    $$n++;
                }
            }
        }

        $array = array();
        for($i = 1; $i<=60;$i++){
            $a = 'n'. ($i < 10 ? "0".$i : $i);
            $array[$i] = $$a;

        }


        asort($array);

        $html = "<h1>Resultados</h1>";
        $html.= "<table>";
        foreach ($array as $k => $l) {
            $html .= '<tr><td>'. $k .'</td><td>'. $l .'</td></tr>';
        }
        $html .= '</table>';

        $pagename = "resultados.html";


        $fp = fopen($pagename , "w");
        $fw = fwrite($fp, $html);

        if($fw == strlen($html)) {
            echo 'Arquivo criado com sucesso!!';
        }else{
            echo 'falha ao criar arquivo';
        }

        //var_dump($array);
    }
}