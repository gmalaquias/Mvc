<?php
/**
 * @author: Gabriel Malaquias
 */

namespace Helpers;

class Validation
{
    static function Required($var)
    {
        if (trim($var) == '')
            return false;
        return true;
    }

    static function Lenght($var, $max, $min = 0)
    {
        if (strlen(trim($var)) <= $max && strlen(trim($var)) >= $min)
            return true;
        return false;
    }

    static function Number($var)
    {
        if (is_numeric($var))
            return true;
        return false;
    }

    static function Range($var, $max, $min = 0)
    {
        if (self::Number($var) && $var <= $max && $var >= $min)
            return true;
        return false;
    }

    static function Email($var)
    {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if (!preg_match($regex, $var)) {
            return false;
        } else {
            return true;
        }
    }

    static function Date($var, $type = "br")
    {
        switch ($type) {
            case "br":
                if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $var))
                    return true;
                return false;
                break;

            case "eu":
                if (preg_match('/^\d{4}\-\d{1,2}\-\d{1,2}$/', $var))
                    return true;
                return false;
                break;
        }
    }

    static function Compare($var1, $var2)
    {
        if ($var1 === $var2)
            return true;
        return false;
    }

    static function validaCPF($cpf = null)
    {
        // Verifica se um n�mero foi informado
        if (empty($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $cpf = preg_replace('[^0-9]', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados � igual a 11
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequ�ncias invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        else
            if ($cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf ==
                '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf ==
                '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf ==
                '99999999999'
            ) {
                return false;
                // Calcula os digitos verificadores para verificar se o
                // CPF � v�lido
            } else {

                for ($t = 9; $t < 11; $t++) {

                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $cpf{$c} * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf{$c} != $d) {
                        return false;
                    }
                }

                return true;
            }
    }

    static function validaCnpj($cnpj)
    {
        $cnpj = trim($cnpj);
        $soma = 0;
        $multiplicador = 0;
        $multiplo = 0;


        # [^0-9]: RETIRA TUDO QUE N�O � NUM�RICO,  "^" ISTO NEGA A SUBSTITUI��O, OU SEJA, SUBSTITUA TUDO QUE FOR DIFERENTE DE 0-9 POR "";
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if (empty($cnpj) || strlen($cnpj) != 14)
            return false;

        # VERIFICA��O DE VALORES REPETIDOS NO CNPJ DE 0 A 9 (EX. '00000000000000')
        for ($i = 0; $i <= 9; $i++) {
            $repetidos = str_pad('', 14, $i);

            if ($cnpj === $repetidos)
                return false;
        }

        # PEGA A PRIMEIRA PARTE DO CNPJ, SEM OS D�GITOS VERIFICADORES
        $parte1 = substr($cnpj, 0, 12);

        # INVERTE A 1� PARTE DO CNPJ PARA CONTINUAR A VALIDA��O    $parte1_invertida = strrev($parte1);

        # PERCORRENDO A PARTE INVERTIDA PARA OBTER O FATOR DE CALCULO DO 1� D�GITO VERIFICADOR
        for ($i = 0; $i <= 11; $i++) {
            $multiplicador = ($i == 0) || ($i == 8) ? 2 : $multiplicador;

            $multiplo = ($parte1_invertida[$i] * $multiplicador);

            $soma += $multiplo;

            $multiplicador++;
        }

        # OBTENDO O 1� D�GITO VERIFICADOR
        $rest = $soma % 11;

        $dv1 = ($rest == 0 || $rest == 1) ? 0 : 11 - $rest;

        # PEGA A PRIMEIRA PARTE DO CNPJ CONCATENANDO COM O 1� D�GITO OBTIDO
        $parte1 .= $dv1;

        # MAIS UMA VEZ INVERTE A 1� PARTE DO CNPJ PARA CONTINUAR A VALIDA��O
        $parte1_invertida = strrev($parte1);

        $soma = 0;

        # MAIS UMA VEZ PERCORRE A PARTE INVERTIDA PARA OBTER O FATOR DE CALCULO DO 2� D�GITO VERIFICADOR
        for ($i = 0; $i <= 12; $i++) {
            $multiplicador = ($i == 0) || ($i == 8) ? 2 : $multiplicador;

            $multiplo = ($parte1_invertida[$i] * $multiplicador);

            $soma += $multiplo;

            $multiplicador++;
        }

        # OBTENDO O 2� D�GITO VERIFICADOR
        $rest = $soma % 11;

        $dv2 = ($rest == 0 || $rest == 1) ? 0 : 11 - $rest;

        # AO FINAL COMPARA SE OS D�GITOS OBTIDOS S�O IGUAIS AOS INFORMADOS (OU A SEGUNDA PARTE DO CNPJ)
        return ($dv1 == $cnpj[12] && $dv2 == $cnpj[13]) ? true : false;
        //echo ($dv1 == $cnpj[12] && $dv2 == $cnpj[13]) ? 'TRUE' : 'FALSE';
    }
}
