<?php

/**
 * Classe para trabalhar com banco de dados usando PDO.
 *
 * @author TreinaWeb
 * @access public
 */
namespace Mvc;

use \PDO;

class Database extends PDO
{
    /**
     * Inicializa a conex�o com o banco de dados
     * @access public
     * @return void
     */

    public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
    {
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        );
        // Executa o construtor da da classe pai (PDO) que inicializa a conex�o
        try {
            parent::__construct($DB_TYPE . ':host=' . $DB_HOST . ';dbname=' . $DB_NAME . ';charset=utf8', $DB_USER, $DB_PASS, $options);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Select no banco de dados.
     * @access public
     * @param String $sql Comando SQL.
     * @param Array $array Dados a serem retornados.
     * @param Boolean $all Usar fetchAll() ou apenas fetch()
     * @param Constant $fetchMode Define o tipo do retorno, por padr�o, um array associativo.
     * @return Array
     */

    public function select($sql, $class = "", $all = FALSE, $array = array())
    {
        // Prepara a Query
        $sth = $this->prepare($sql);

        // Define os dados do Where, se existirem.
        foreach ($array as $key => $value) {
            // Se o tipo do dado for inteiro, usa PDO::PARAM_INT, caso contr�rio, PDO::PARAM_STR
            $tipo = (is_int($value)) ? PDO::PARAM_INT : PDO::PARAM_STR;

            // Define o dado
            $sth->bindValue("$key", $value, $tipo);
        }

        // Executa
        $sth->execute();

        // Executar fetchAll() ou fetch()?

        // Retorna a cole��o de dados (array multidimensional)


        if ($sth->rowCount() <= 0)
            return null;

        if ($class == "") {

            if ($all == false and $sth->rowCount() == 1) {
                $array = $sth->fetchAll(PDO::FETCH_OBJ);
                return array_shift($array);
            }

            return $sth->fetchAll(PDO::FETCH_OBJ);
        } else {
            if ($all == false and $sth->rowCount() == 1) {
                $array = $sth->fetchAll(PDO::FETCH_CLASS, $this->getClass($class));
                return array_shift($array);
            }

            return $sth->fetchAll(PDO::FETCH_CLASS, $this->getClass($class));
        }

    }


    function getClass($class){
        if(is_object($class))
            return get_class($class);
        return $class;
    }

    /**
     * Insere um dado no banco de dados.
     * @access public
     * @param String $table Nome da tabela.
     * @param Array $data Campos e seus respectivos valores.
     * @return Integer
     */

    public function insert($table, $data)
    {
        if (is_object($data))
            ModelState::RemoveNotMapped($data);

        $data = (array)$data;

        // Ordena
        ksort($data);

        // Campos e valores
        $camposNomes = implode('`, `', array_keys($data));
        $camposValores = ':' . implode(', :', array_keys($data));

        // Prepara a Query
        $sth = $this->prepare("INSERT INTO $table (`$camposNomes`) VALUES ($camposValores)");

        // Define os dados
        foreach ($data as $key => $value) {
            // Se o tipo do dado for inteiro, usa PDO::PARAM_INT, caso contr�rio, PDO::PARAM_STR
            $tipo = (is_int($value)) ? PDO::PARAM_INT : PDO::PARAM_STR;

            // Define o dado
            $sth->bindValue(":$key", $value, $tipo);
        }

        // Executa
        $sth->execute();

        // Retorna o ID desse item inserido
        return $this->lastInsertId();
    }

    /**
     * Atualiza um dado no banco de dados.
     * @access public
     * @param String $table Nome da tabela.
     * @param Array $data Campos e seus respectivos valores.
     * @param String $where Condi��o de atualiza��o.
     * @return Integer
     */

    public function update($table, $data, $where)
    {
        if (is_object($data))
            ModelState::RemoveNotMapped($data);

        $data = (array)$data;
        // Ordena
        ksort($data);

        // Define os dados que ser�o atualizados
        $novosDados = NULL;

        foreach ($data as $key => $value) {
            $novosDados .= "`$key`=:$key,";
        }

        $novosDados = rtrim($novosDados, ',');

        // Prepara a Query
        $sth = $this->prepare("UPDATE $table SET $novosDados WHERE $where");

        // Define os dados
        foreach ($data as $key => $value) {
            // Se o tipo do dado for inteiro, usa PDO::PARAM_INT, caso contr�rio, PDO::PARAM_STR
            $tipo = (is_int($value)) ? PDO::PARAM_INT : PDO::PARAM_STR;

            // Define o dado
            $sth->bindValue(":$key", $value, $tipo);
        }

        // Sucesso ou falha?
        return $sth->execute();
    }

    /**
     * Deleta um dado da tabela.
     * @access public
     * @param String $table Nome da tabela.
     * @param String $where Condi��o de atualiza��o.
     * @param Integer $limit Limite de itens deletados por execu��o.
     * @return Integer
     */

    public function delete($table, $where, $limit = 1)
    {
        // Deleta
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }
}