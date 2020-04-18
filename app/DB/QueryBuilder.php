<?php

namespace App\DB;

use PDO;

class QueryBuilder
{
    protected $pdo;
    public $statement;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function find($table, $id)
    {
        $statement = $this->pdo->prepare("select * from {$table} where id = :id");

        $statement->execute(array(':id'=>$id));

        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public function count($table)
    {
        $statement = $this->pdo->prepare("select count(*) from {$table}");

        $statement->execute();

        return $statement->fetchColumn();
    }

    public function select($table)
    {
        $statement = "select * from {$table} order by id desc";

        $this->statement = $statement;

        return $this;
    }

    public function paginate($startLimit, $rowsPerPage)
    {
        $this->statement .= " limit {$startLimit}, {$rowsPerPage}";

        return $this;
    }

    public function get()
    {
        $statement = $this->pdo->prepare($this->statement);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $result = $statement->execute($parameters);
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function update($table, $parameters, $id)
    {
        $placeholders = array_reduce(array_keys($parameters), function ($carry, $item) use ($id) {
            if ('id' != $item) {
                $carry .= "{$item} = :{$item}, ";
            }
            return $carry;
        }, '');
        $placeholders = rtrim($placeholders, ", ");
        $sql = "update {$table} set {$placeholders} where id = :id";

        try {
            $parameters = array_reduce(array_keys($parameters), function ($carry, $item) use ($parameters) {
                $key = ':' . $item;
                $carry[$key] = $parameters[$item];
                return $carry;
            }, []);
            $statement = $this->pdo->prepare($sql);
            $result = $statement->execute($parameters);
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}