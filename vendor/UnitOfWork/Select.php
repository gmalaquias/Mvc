<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 05/01/2015
 * Time: 09:07
 */

namespace UnitOfWork;


use Mvc\Database;

class Select {

    /**
     * Usada para montar a query que sera executada
     * @var String
     */
    public $query;

    /**
     * Passa nomes dos attributos virtuais para seu preenchimento
     * @var bool
     */
    public $persist;

    /**
     * Verifica se ja foi chamado o metodo OrderBy ou OrderByDescending
     * @var bool
     */
    private $order = false;

    /**
     * Usada pra pegar os dados do banco
     * @var Database
     */
    private $db;

    /**
     * Guarda o tipo da classe que esta sendo buscado
     */
    private $type;

    /**
     * Guarda o Limit da query
     * @var int
     */
    private $limit = null;

    /**
     * Guarda o numero de registros que devem ser pulados na busca
     * @var int
     */
    private $skip = null;

    /**
     * Campos que serão selecionados
     */
    private $select = '*';

    /**
     * Usado para verificar se existe se um campo no select
     */
    private $getUnique = false;

    function __construct($type, $query, $persist){
        $this->type = $type;
        $this->query = $query;
        $this->persist = $persist;
        $this->db = new Database();
    }

    function FirstOrDefault(){
        $this->limit = 1;
        return $this->ExecuteQuery(false);
    }

    function ToList(){
        return $this->ExecuteQuery(true);
    }

    function OrderBy($campo){
        if($this->order)
            $this->query = $this->query . ", ".$campo;
        else
            $this->query = $this->query . " ORDER BY ".$campo;

        $this->order = true;
        return $this;
    }

    function OrderByDescending($campo){
        if($this->order)
            $this->query = $this->query . ", ".$campo . " DESC";
        else
            $this->query = $this->query . " ORDER BY ".$campo . " DESC";

        $this->order = true;
        return $this;
    }

    function Take($take){
        if(is_numeric($take))
            $this->limit = $take;
        return $this;
    }

    function Skip($skip){
        if(is_numeric($skip))
            $this->skip = $skip;
        return $this;
    }

    function Select($select){
        $this->select = $select;
        if($select != '*' AND count(explode(',',$select)) == 1)
            $this->getUnique = true;
        return $this;
    }

    function Join($join){}

    private function ExecuteQuery($all = true){
        $classe = NAMESPACE_ENTITIES . $this->type;
        $query = $this->getQuery();

        return $this->db->select($query,(class_exists ($classe) && !$this->getUnique ? $classe : ''),$all);
    }

    private function getQuery(){
        $query = $this->query;
        if($this->limit != null && $this->skip != null)
            $query .= " LIMIT ".$this->skip.','.$this->limit;
        else if($this->skip == null && $this->limit != null)
            $query .= " LIMIT " .$this->limit;
        else if($this->skip != null && $this->limit == null)
            $query .= " LIMIT " .$this->skip . ', 10000000000';

        $query = str_replace('*',$this->select,$query);

        return $query;
    }


} 