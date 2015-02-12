<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 05/01/2015
 * Time: 09:07
 */

namespace UnitOfWork;


use Helpers\ModelState;
use Mvc\Database;

class Select
{

    /**
     * Usada para montar a query que sera executada
     * @var String
     */
    public $query;

    /**
     * Guarda a seção de db do UnitOfWork
     */
    private $db;

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

    function __construct($type, $query, $persist, $db)
    {
        $this->type = $type;
        $this->query = $query;
        $this->persist = $persist;
        $this->db = $db;
    }

    function FirstOrDefault()
    {
        $this->limit = 1;
        return $this->ExecuteQuery(false);
    }

    function ToList()
    {
        return $this->ExecuteQuery(true);
    }

    function OrderBy($campo)
    {
        if ($this->order)
            $this->query = $this->query . ", " . $campo;
        else
            $this->query = $this->query . " ORDER BY " . $campo;

        $this->order = true;
        return $this;
    }

    function OrderByDescending($campo)
    {
        if ($this->order)
            $this->query = $this->query . ", " . $campo . " DESC";
        else
            $this->query = $this->query . " ORDER BY " . $campo . " DESC";

        $this->order = true;
        return $this;
    }

    function Take($take)
    {
        if (is_numeric($take))
            $this->limit = $take;
        return $this;
    }

    function Skip($skip)
    {
        if (is_numeric($skip))
            $this->skip = $skip;
        return $this;
    }

    function Select($select, $novaClasse = "")
    {
        $this->select = $select;
        if ($select != '*' AND count(explode(',', $select)) == 1)
            $this->getUnique = true;
        return $this;
    }

    function Join(Select $join, $on, $on2)
    {
        var_dump($join);

        return $this;
    }

    function LeftJoin(Select $join, $on, $on2){}

    private function ExecuteQuery($all = true)
    {
        $classe = NAMESPACE_ENTITIES . $this->type;
        $query = $this->getQuery();

        $result = $this->db->select($query, (class_exists($classe) && !$this->getUnique ? $classe : ''), $all);
        return $this->ExecutePersist($result, $all);
    }

    private function getQuery()
    {
        $query = $this->query;
        if ($this->limit != null && $this->skip != null)
            $query .= " LIMIT " . $this->skip . ',' . $this->limit;
        else if ($this->skip == null && $this->limit != null)
            $query .= " LIMIT " . $this->limit;
        else if ($this->skip != null && $this->limit == null)
            $query .= " LIMIT " . $this->skip . ', 10000000000';

        $query = str_replace('*', $this->select, $query);

        return $query;
    }

    private function ExecutePersist($result, $all)
    {
        if ($this->persist == null || $result == null)
            return $result;

        $persist = explode(",", $this->persist);

        $obj = NAMESPACE_ENTITIES . $this->type;
        $obj = new $obj;

        $virtuals = ModelState::GetVirtuals($obj);

        foreach ($persist as $key => $value) {
            $ex = explode(".", $value);
            $value = $ex[0];
            if (!array_key_exists("_" . $value, $virtuals))
                unset($persist[$key]);
        }

        if (is_object($result))
            $result = array($result);

        $count = count($result);
        for ($i = 0; $i < $count; $i++) {
            foreach ($persist as $k => $p) {
                $p = "_" . $p;
                $novoPersist = explode(".", $p);
                if (count($novoPersist) == 2) {
                    $p = $novoPersist[0];
                    $novoPersist = $novoPersist[1];
                } else {
                    $novoPersist = null;
                }
                $table = $virtuals[$p]["Type"];
                $fk = $virtuals[$p]["Fk"];

                $unitofwork = new UnitOfWork();
                $result[$i]->$p = $unitofwork->Get($table, $fk . " = " . $result[$i]->$fk, $novoPersist)->ToList();
            }
        }

        if ($count == 1 && $all == false)
            return $result[0];

        return $result;
    }
} 