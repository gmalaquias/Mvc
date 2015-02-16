<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 09/01/2015
 * Time: 14:29
 */

namespace Helpers;


class EmailHelper {

    static function  email($assunto, $msg, $remetente, $nomeRemetente, $destino, $nomeDestino){
        $path =  VENDOR . "phpmailer" . DS . "phpmailer" . DS;
        require_once $path . 'PHPMailerAutoload.php';
        $mail = new \PHPMailer();

        $mail->IsSMTP();
        $mail->setLanguage('br');
        $mail->SMTPAuth = true;
        $mail->Host = HOST_EMAIL;

        $mail->Username = USER_EMAIL;
        $mail->Password = PASS_EMAIL;

        $mail->From = $remetente; //remetente
        $mail->FromName = utf8_decode($nomeRemetente); //remetente nome
        $mail->AddReplyTo($remetente, utf8_decode($nomeRemetente));
        $mail->IsHTML(true);

        $mail->Subject = utf8_decode($assunto); //assunto
        $mail->Body = utf8_decode($msg); //mensagem
        $mail->AddAddress($destino, utf8_decode($nomeDestino)); //email e nome destino

        return $mail->Send();
    }

} 