<?php


namespace Muhep\ExchangeRates\Utils;

class Table
{
    private $table;
    private $export;
    private $index;
    private $drop = false;
    private $exist = false;
    private $useSoftDelete = false;

    public function __construct($table)
    {
        $this->table = $table;
        $this->export = [];
        $this->index = -1;
        $this->useSoftDelete = false;
    }

    private function insert($type)
    {
        $this->export[$this->index]['types']['extras'][count($this->export[$this->index]['types']['extras'])] = $type;
    }

    private function makeRelation($references, $on) {
        $this->export[$this->index]['types']['extras']['relation'] = [ 'references' => $references, 'on' => $on ];
    }

    private function start($name, $type)
    {
        $this->index++;
        $this->export[$this->index] =  [ 'name' => $name, 'types' => [ $type, 'extras' => [] ] ];
    }

    public function string($name): Table
    {
        $this->start($name, 'string');
        return $this;
    }

    public function text($name): Table
    {
        $this->start($name, 'text');
        return $this;
    }

    public function integer($name): Table
    {
        $this->start($name, 'integer');
        return $this;
    }

    public function bigIncrements($name): Table
    {
        $this->start($name, 'bigIncrements');
        return $this;
    }

    public function increments($name): Table
    {
        $this->start($name, 'increments');
        return $this;
    }

    public function float($name): Table
    {
        $this->start($name, 'float');
        return $this;
    }

    public function timestamp($name): Table
    {
        $this->start($name, 'timestamp');
        return $this;
    }

    public function unsignedBigInteger($name): Table
    {
        $this->start($name, 'unsignedBigInteger');
        return $this;
    }

    public function uuid($name): Table
    {
        $this->start($name, 'uuid');
        return $this;
    }

    public function relation($references, $on): Table
    {
        $this->makeRelation($references, $on);
        return $this;
    }


    public function unique(): Table
    {
        $this->insert('unique');
        return $this;
    }

    public function index(): Table {
        $this->insert('index');
        return $this;
    }

    public function nullable(): Table
    {
        $this->insert('nullable');
        return $this;
    }

    public function autoIncrement(): Table
    {
        $this->insert('autoIncrement');
        return $this;
    }

    public function primary(): Table
    {
        $this->insert('primary');
        return $this;
    }

    public function timestamps(): Table
    {
        return $this;
    }

    public function softDelete(): Table
    {
        $this->useSoftDelete = true;
        return $this;
    }

    public function isUseSoftDelete(): bool
    {
        return $this->useSoftDelete;
    }

    /**
     * @param bool $drop
     */
    public function setDropIfExist(bool $drop): void
    {
        $this->drop = $drop;
    }

    /**
     * @return bool
     */
    public function isDropIfExist(): bool
    {
        return $this->drop;
    }

    /**
     * @param bool $exist
     */
    public function setContinueIfExist(bool $exist): void
    {
        $this->exist = $exist;
    }

    /**
     * @return bool
     */
    public function isContinueIfExist(): bool
    {
        return $this->exist;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getColumns()
    {
        return $this->export;
    }
}
