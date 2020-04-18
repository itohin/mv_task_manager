<?php

namespace App\DB;

use PDO;

class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
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

    public function paginate($table, $startLimit, $rowsPerPage)
    {
        $statement = $this->pdo->prepare("select * from {$table} order by id desc limit {$startLimit}, {$rowsPerPage}");

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
        $parameters = array

        $sql = sprintf(
            'update %s set (%s) where id = :id',
            $table,
            implode(', ', array_keys($parameters))
        );

        dd($sql);

        try {
            $parameters['id'] = $id;
            $statement = $this->pdo->prepare($sql);
            $result = $statement->execute($parameters);
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}