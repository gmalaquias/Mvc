<?php

namespace Helpers;

class UploadHelper {
    
    function upload($arquivo,$nome,$pasta){
    	// Pasta onde o arquivo vai ser salvo
		$_UP['pasta'] = $pasta;
		// Tamanho máximo do arquivo (em Bytes)
		$_UP['tamanho'] = 1024 * 1024 * 15; // 15Mb
		// Array com as extensões permitidas
		//$_UP['extensoes'] = array('jpg', 'png', 'gif','docx', 'doc', 'pdf', 'ppt', 'pptx');
		// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
    	$_UP['renomeia'] = true;
		// Array com os tipos de erros de upload do PHP
		$_UP['erros'][0] = 'Não houve erro';
		$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite';
		$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
		$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
		$_UP['erros'][4] = 'Não foi feito o upload do arquivo';

		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($arquivo['error'] != 0) {
			die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$arquivo['error']]);
			exit; // Para a execução do script
		}
		// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
		// Faz a verificação da extensão do arquivo
		$extensao = strtolower(end(explode('.', $arquivo['name'])));
		/*if (array_search($extensao, $_UP['extensoes']) === false) {
			echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
		}*/
		// Faz a verificação do tamanho do arquivo
		if ($_UP['tamanho'] < $arquivo['size']) {
			$erro = "O arquivo enviado é muito grande, envie arquivos de até 15Mb.";
			$return['erro'] = $erro;
		}

		// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
		else {
		// Primeiro verifica se deve trocar o nome do arquivo
		if ($_UP['renomeia'] == false) {
		// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
		$nome_final = time().'.jpg';
		} else {
		// Mantém o nome original do arquivo
		$nome_final = $nome.'.'.$extensao;
			if(file_exists($_UP['pasta'].$nome_final)){
				$nome_final = $nome.date('is').'.'.$extensao;
			}
		}

		// Depois verifica se é possível mover o arquivo para a pasta escolhida
		if (move_uploaded_file($arquivo['tmp_name'], $_UP['pasta'] . $nome_final)) {
		// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
		} else {
		// Não foi possível fazer o upload, provavelmente a pasta está incorreta
		$erro = "Não foi possível enviar o arquivo, tente novamente";
		$return['erro'] = $erro;
		}
		
		$return['nome'] = $nome_final;

		return $return;
		}
	}
    
    function upload_img($tmp, $name, $nome_imagem, $larguraP, $pasta){
		$ext = strtolower($name);
		$aux =explode('.',$ext);
		$ext  = end($aux);
		$a = 1;
		if($ext =='jpg'){
			$img = imagecreatefromjpeg($tmp);
		}elseif($ext=='gif'){
			$img = imagecreatefromgif($tmp);
		}else{
			$img = imagecreatefrompng($tmp);
			$a = 2;
		}
		$x = imagesx($img);
		$y = imagesy($img);
		
		$largura = ($x>$larguraP) ? $larguraP : $x;
		$altura = ($largura * $y)/ $x;
		
		if($altura>$larguraP){
			$altura = $larguraP;
			$largura = ($altura*$x) / $x;
		}
		$nova = imagecreatetruecolor($largura, $altura);
		if($a == 2){
		imagealphablending ($nova, true);
		$transparente = imagecolorallocatealpha ($nova, 0, 0, 0, 127);
		imagefill ($nova, 0, 0, $transparente);	
		imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
		imagesavealpha($nova, true);
		imagedestroy($img);
		imagepng($nova, "images/".$pasta."/$nome_imagem");
		imagedestroy($nova);	
		}else{
		imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
		imagedestroy($img);
		imagejpeg($nova, "images/".$pasta."/$nome_imagem");
		imagedestroy($nova);
		}
		
		return($nome_imagem);
	
	}
    
}