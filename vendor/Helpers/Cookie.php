<?php

/**
 * Classe para trabalhar com dados de sessão
 *
 * @author Gabriel Malaquias
 * @access public
 */

namespace Helpers;

class Cookie
{

    public $Titulo; #Titulo do Cookie
    public static $Valores; #Array - Valores do Cookie
    public $Tempo; #Tempo do Cookie
    private $Dominio;
    private $Path;

    public function __construct($Titulo, $Tempo = -1)
    {
        if ($Tempo == -1) $Tempo = time() + 3600 * 24 * 30;

        $this->Titulo = $Titulo;
        self::$Valores = ' ';
        $this->Tempo = $Tempo;
        $this->Dominio = $_SERVER['HTTP_HOST'];
        $this->Path = "/";

        if (!isset($_COOKIE[$Titulo]))
            return $this->setValueCookie(self::$Valores);

        return $this->setValueCookie($this->getCookie());
    }


    /**
     * Grava uma informação no cookie
     * @access public
     * @param String $key
     * @param String $value
     * @return void
     */

    public function set($key, $value)
    {
        $key = strtolower($key);

        //Seta o valor indicado
        self::$Valores[$key] = $value;

        //Serializa
        $serializado = $this->ConvertToQueryString(self::$Valores);

        //Salva
        $this->setValueCookie($serializado);
    }

    /**
     * Retorna um dado do cookie
     * @access public
     * @param String $key
     * @return String
     */

    public function get($key)
    {
        $key = strtolower($key);

        if (isset(self::$Valores[$key]))
            return self::$Valores[$key];
        else
            return null;
    }

    /**
     * Deleta um dado da sessão
     * @access public
     * @param String $key
     * @return void
     */
    public function delete($key = "")
    {
        $key = strtolower($key);
        //Serializa
        $valores  = self::$Valores;

        //Verifica campo
        if (isset($valores[$key])) {
            //Apaga valor desejado
            $valores[$key] = "";
            unset($valores[$key]);
            //Serializa
            $serializado = $this->ConvertToQueryString($valores);
            //Salva
           $this->setValueCookie($serializado);
        }
    }

    /**
     * Destrói todos os dados do cookie
     * @access public
     * @return void
     */

    public function destroy()
    {
        unset($_COOKIE[$this->Titulo]);
        setcookie($this->Titulo, '', time() - 3600, $this->Path); // empty value and old timestamp
    }


    private function setValueCookie($value){
        self::$Valores = $this->ConvertToArray($value);
        setcookie($this->Titulo, $value, $this->Tempo, $this->Path);
    }

    private function ConvertToArray($str){
        $str = str_replace("Cookie","&", $str);
        parse_str($str, $output);

        return $output;
    }

    private function ConvertToQueryString( $array ){

        $query_array = array();

        if(is_array($array)) {
            foreach ($array as $key => $key_value) {

                $query_array[] = urlencode($key) . '=' . urlencode($key_value);

            }

            return implode('&', $query_array);
        }

        return '';
    }

    private function getCookie(){
        return $_COOKIE[$this->Titulo];
    }
}