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

class UnitOfWork {

    private $db;

    private $transaction = false;

    function __construct(){
        $this->db = new Database();
        return $this;
    }

    function Get($type, $where = null, $persist = null){
        $get = new Crud($type);
        return $get->Get($where,$persist);
    }

    function GetById($type, $id){
        $newClass = NAMESPACE_ENTITIES . $type;
        if(class_exists ($newClass)) {
            $class = new $newClass();
            $primaryKey = ModelState::GetPrimary($class);
            if ($primaryKey != null)
                return $this->Get($primaryKey . '=' . $id)->FirstOrDefault();

            return null;
        }

        throw new UnitOfWorkException("Classe {$newClass} não encontrada", 1);
    }

    function ExecuteQuery(){

    }

    function Insert($model){
         $this->OpenTransaction();

        $data = clone $model;

        $table = str_replace(NAMESPACE_ENTITIES , "",  get_class($data));

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
        $sth = $this->db->prepare("INSERT INTO $table (`$camposNomes`) VALUES ($camposValores)");

        // Define os dados
        foreach ($data as $key => $value) {
            // Se o tipo do dado for inteiro, usa PDO::PARAM_INT, caso contr�rio, PDO::PARAM_STR
            $tipo = (is_int($value)) ? \PDO::PARAM_INT : \PDO::PARAM_STR;

            // Define o dado
            $sth->bindValue(":$key", $value, $tipo);
        }

        // Executa
        $sth->execute();

        $primaryKey = ModelState::GetPrimary($model);
        if(!empty($primaryKey))
            $model->$primaryKey = $this->db->lastInsertId();
        return $this->db->lastInsertId();
    }

    function Save(){
        if($this->transaction) {
            try {
                $this->db->commit();
                $this->db->exec("SET FOREIGN_KEY_CHECKS = 1;");
            } catch (\Exception $e) {
                $this->db->rollBack();
                echo $e->getMessage();
            }

            $this->transaction = false;
        }
    }

    private function OpenTransaction(){
        unset($this);
    }




} 