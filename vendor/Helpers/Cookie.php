<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 28/01/2015
 * Time: 11:37
 */

namespace Helpers;

//TODO: ARRUMAR CLASSE
class Cookie
{
    public $Titulo; #Titulo do Cookie
    public $Valores; #Array - Valores do Cookie
    public $Tempo; #Tempo do Cookie
    private $Dominio;
    private $Path;

    public function __construct($Titulo, $Valores = null, $Tempo = -1)
    {
        if($Tempo == -1) $Tempo = time()+3600*24*30;

        $this->Titulo = $Titulo;
        $this->Valores = is_array($Valores) ? $Valores : Array();
        $this->Tempo = $Tempo;
        $this->Dominio = $_SERVER['HTTP_HOST'];
        $this->Path = "/";

        if(!isset($_COOKIE[$Titulo]))
        {
            $val = is_array($Valores) ? serialize($Valores) : true;
            setcookie($this->Titulo, $val, $this->Tempo, $this->Path);
        }

        return $this;
    }

    public function Definir($Campo, $Valor)
    {
        $cookie = null;
        //Busca o cookie
        if(isset($_COOKIE[$this->Titulo]))
        {
            $cookie = $_COOKIE[$this->Titulo];
        }else
        {
            setcookie($this->Titulo, true, $this->Tempo, $this->Path);
            $cookie = $_COOKIE[$this->Titulo];
        }
        //echo $cookie;
        //Pega todos os valores
        $this->Valores = unserialize($cookie);

        //Seta o valor indicado
        $this->Valores[$Campo] = $Valor;

        //Serializa
        $serializado = serialize($this->Valores);

        //Salva
        setcookie($this->Titulo,$serializado, $this->Tempo, $this->Path);

        return $this;
    }

    public function Ver($Campo)
    {
        $Campo = strtolower($Campo);

        $cookie = $_COOKIE[$this->Titulo];
        $this->Valores = unserialize($cookie);


        if(isset($this->Valores[$Campo]))
            return $this->Valores[$Campo];
        else
            return null;
    }

    public static function DefinirSimples($Titulo, $Valor, $Tempo = -1)
    {
        if($Tempo == -1) $Tempo = time()+3600*24*30;

        setcookie($Titulo,$Valor, $Tempo, "/", $_SERVER['HTTP_HOST']);
    }
    public static function Deletar($Titulo, $Campo = ""){
        if(isset($_COOKIE[$Titulo])) {
            if (empty($Campo)) {
                $_COOKIE[$Titulo] = "";
                unset($_COOKIE[$Titulo]);
            } else {
                //Pega Session
                $cookie = $_COOKIE[$Titulo];
                //Serializa
                $valores = @unserialize($cookie) !== FALSE ? unserialize($cookie) : Array();
                //Verifica campo
                if (isset($valores[$Campo])) {
                    //Apaga valor desejado
                    $valores[$Campo] = "";
                    unset($valores[$Campo]);
                    //Serializa
                    $serializado = serialize($valores);
                    //Salva
                    $_COOKIE[$Titulo] = $serializado;
                }
            }
        }
    }
}