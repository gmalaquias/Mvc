<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 05/01/2015
 * Time: 10:22
 */

namespace UnitOfWork;


use Helpers\ModelState;
use Mvc\Database;

class UnitOfWork extends Database {

    private $transactionActive = false;

    /**
     * Construtor
     */
    function __construct(){
        parent::__construct();
        return $this;
    }

    /**
     * @param $type
     * @param null $where
     * @param null $persist
     * @return Select
     */
    function Get($type, $where = null, $persist = null){
        $get = new Crud($type);
        return $get->Get($where,$persist,$this);
    }

    /**
     * Seleciona pelo Id
     * @param $type
     * @param $id
     * @throws UnitOfWorkException
     */
    function GetById($type, $id){
        $newClass = NAMESPACE_ENTITIES . $type;
        if(class_exists ($newClass)) {
            $class = new $newClass();
            $primaryKey = ModelState::GetPrimary($class);
            if ($primaryKey != null)
                return $this->Get($type, $primaryKey . '=' . $id)->FirstOrDefault();

            return null;
        }

        throw new UnitOfWorkException("Classe {$newClass} não encontrada", 1);
    }

    /**
     * Insere dados no banco atraves de uma model mapeada
     * @param $model
     * @return string
     */
    function Insert($model){
        $this->OpenTransaction();

        $data = clone $model;

        $table = $this->getTableName($data);

        //verifico se é um objeto
        if (is_object($model))
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
            $tipo = (is_int($value)) ? \PDO::PARAM_INT : \PDO::PARAM_STR;

            // Define o dado
            $sth->bindValue(":$key", $value, $tipo);
        }

        // Executa
        try {
            $sth->execute();
        }catch (\Exception $e){
            echo $e->getMessage();
        }

        $primaryKey = ModelState::GetPrimary($model);
        if(!empty($primaryKey))
            $model->$primaryKey = $this->lastInsertId();
        return $this->lastInsertId();
    }


    public function Update($model, $campos)
    {
        $data = clone $model;

        if (is_object($data))
            ModelState::RemoveNotMapped($data);

        $primaryKey = ModelState::GetPrimary($model);
        if($primaryKey == null)
            throw new UnitOfWorkException("Classe nao contem PK");

        $table = $this->getTableName($data);

        $data = (array)$data;

        $novosDados = NULL;

        foreach ($campos as $key) {
            $novosDados .= "`$key`=:$key,";
        }

        $novosDados = rtrim($novosDados, ',');

        // Prepara a Query
        $sth = $this->prepare("UPDATE $table SET $novosDados WHERE $primaryKey = '".$model->$primaryKey."'");

        // Define os dados
        foreach ($campos as $key) {
            // Se o tipo do dado for inteiro, usa PDO::PARAM_INT, caso contr�rio, PDO::PARAM_STR
            $tipo = (is_int($model->$key)) ? \PDO::PARAM_INT : \PDO::PARAM_STR;

            // Define o dado
            $sth->bindValue(":$key", $model->$key, $tipo);
        }

        try {
            $sth->execute();
            $model = $this->GetById($table,$model->$primaryKey);
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Faz o commit dos dados enviados
     * Caso ocorra algum erro, não envia nada
     */
    public function Fim(){
        var_dump($this->transactionActive);
//        if($this->transaction) {
//            try {
//                $this->commit();
//                $this->exec("SET FOREIGN_KEY_CHECKS = 1;");
//            } catch (\Exception $e) {
//                $this->rollBack();
//                echo $e->getMessage();
//            }
//
//            $this->transactionActive = false;
//        }

        return false;
    }


    public function Save(){
        if($this->transactionActive) {
            try {
                $this->commit();
                $this->exec("SET FOREIGN_KEY_CHECKS = 1;");
            } catch (\Exception $e) {
                $this->rollBack();
                echo $e->getMessage();
            }

            $this->transactionActive = false;
        }

        return false;
    }

    /**
     * Abre a transaçao com o banco caso não esteja aberta
     */
    private function OpenTransaction(){
        if(!$this->transactionActive) {
            $this->beginTransaction();
            $this->exec("SET FOREIGN_KEY_CHECKS = 0;");
            $this->transactionActive = true;
        }
    }

    /**
     * Pega o nome da tabela atraves do nome da Classe
     * @param $model
     * @return mixed
     */
    private function getTableName($model){
        return str_replace(NAMESPACE_ENTITIES , "",  get_class($model));
    }

    /**
     * Destroi a classe
     */
    function __destruct(){
        unset($this);
    }




} 