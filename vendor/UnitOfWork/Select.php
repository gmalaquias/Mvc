<?php
/**
 * Created by PhpStorm.
 * User: gabriel.malaquias
 * Date: 05/01/2015
 * Time: 09:07
 */

namespace UnitOfWork;


use Helpers\ArrayHelper\ArrayHelper;
use Helpers\ModelState;
use Helpers\StringHelper;
use Mvc\Database;

class Select implements iSelect
{
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
     * Guarda os valores de orderby da query
     */
    private $orderby = null;

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

    /**
     * Guarda o where para a query
     */
    public $where = null;

    /**
     * Guarda os joins
     */
    public $join = null;

    /**
     * alias da tabela principal
     */
    public $as;

    /**
     * Classe de retorno do join
     */
    public $classe = null;

    /**
     * Guarda o groupby da query
     */
    public $groupby;

    /**
     * Guarda a opção DISTINCT do mysql
     */
    public $distinct;

    /**
     * Guarda o having da query
     */
    public $having = null;

    public function __construct($type, $where, $persist, $db)
    {
        $this->type = $type;
        $this->persist = $persist;
        $this->db = $db;
        $this->where = $where;
    }

    public function FirstOrDefault()
    {
        $this->limit = 1;
        return $this->ExecuteQuery(false);
    }

    public function ToList()
    {
        return $this->ExecuteQuery(true);
    }

    public function OrderBy($campo)
    {
        if ($this->orderby != null)
            $this->orderby .= ", " . $campo;
        else
            $this->orderby .= " ORDER BY " . $campo;

        return $this;
    }

    public function OrderByDescending($campo)
    {
        if ($this->orderby != null)
            $this->orderby .= ", " . $campo . " DESC";
        else
            $this->orderby .= " ORDER BY " . $campo . " DESC";

        return $this;
    }

    public function Take($take)
    {
        if (is_numeric($take))
            $this->limit = $take;
        return $this;
    }

    public function Skip($skip)
    {
        if (is_numeric($skip))
            $this->skip = $skip;
        return $this;
    }

    public function Select($select, $novaClasse = null)
    {
        $this->classe = $novaClasse;

        $this->select = $select;
        if ($select != '*' AND count(explode(',', $select)) == 1 AND empty($novaClasse))
            $this->getUnique = true;

        return $this;
    }

    public function Join($join, $on, $on2)
    {
        $this->BuildJoin("INNER", $join,$on,$on2);

        return $this;
    }

    public function LeftJoin($join, $on, $on2){
        $this->BuildJoin("LEFT", $join,$on,$on2);

        return $this;
    }

    public function Where($where){
        if($this->where == null)
            $this->where = $where;
        else
            $this->where .= " AND (".$where.")";

        return $this;
    }

    public function GroupBy($fields){
        if ($this->groupby != null)
            $this->groupby .= ", " . $fields;
        else
            $this->groupby .= " GROUP BY " . $fields;

        return $this;
    }

    public function Sum($field){
        $this->Select("SUM(" . $field . ") as SUM".$field);

        return $this;
    }

    public function AVG($field){
        $this->Select("AVG(" . $field . ") as Avg".$field);

        return $this;
    }

    public function Having($having){
        if($this->having == null)
            $this->having = $having;
        else
            $this->having .= " AND (".$having.")";

        return $this;
    }

    public function Distinct(){
        $this->distinct = " DISTINCT ";
        return $this;
    }

    public function Count(){
        $this->Select("COUNT(*) as Count");

        return $this;
    }

    private function getClass(){

        if($this->join != null){
            if($this->classe != null)
                return is_object($this->classe) ? get_class($this->classe) : (StringHelper::Contains($this->classe, NAMESPACE_ENTITIES) ? $this->classe : NAMESPACE_ENTITIES . $this->classe);
            else
                return '';
        }

        return NAMESPACE_ENTITIES . $this->type;
    }

    private function BuildJoin($type, $join, $on, $on2){
        if($this->join == null && StringHelper::Contains($on,"."))
            $this->as = " AS ". ArrayHelper::getFirstElement(explode(".", $on));

        $as = "";
        if(StringHelper::Contains($on2,"."))
            $as = " AS " . ArrayHelper::getFirstElement(explode(".", $on2));

        if($join instanceof Select) {
            if($join->join != null){
                $this->join .= " " . $type . " JOIN ( ";
                $this->join .= " " . $join->getQuery();
                $this->join .= ")" . $as . " ON " . $on . " = " . $on2;
            }else {
                $this->join .= " " . $type . " JOIN " . $join->type . $as . " ON " . $on . " = " . $on2;
            }
            $this->Where($join->where);
        }
        else if(is_string($join)){
            $this->join .= " " .$type . " JOIN " . $join . $as . " ON " . $on . " = " . $on2;
        }else
            throw new UnitOfWorkException("Tipo não válido");
    }

    private function ExecuteQuery($all = true)
    {
        $classe = $this->getClass();

        $query = $this->getQuery();

        echo $query;

        $result = $this->db->select($query, (class_exists($classe) && !$this->getUnique ? $classe : ''), $all);

        return $this->ExecutePersist($result, $all);
    }

    private function getQuery()
    {
        $query = "SELECT " . $this->distinct . $this->select . " FROM " . $this->type . $this->as . $this->join .
            (!empty($this->where) ? " WHERE " . $this->where : "") .
            $this->groupby .
            (!empty($this->having) ? " HAVING " . $this->having : "");

        if ($this->limit != null && $this->skip != null)
            $query .= " LIMIT " . $this->skip . ',' . $this->limit;
        else if ($this->skip == null && $this->limit != null)
            $query .= " LIMIT " . $this->limit;
        else if ($this->skip != null && $this->limit == null)
            $query .= " LIMIT " . $this->skip . ', 10000000000';


        $query .= $this->orderby;


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