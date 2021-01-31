<?php

namespace DAL\Tools;

class DBTransaction {
    /**
     * @var int 
     */
    private $count;
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo) {
        if ($pdo == null)
            throw new InvalidArgumentException("\$pdo should be set !");

        $this->pdo = $pdo;
    }

    public function Begin() : bool {
        $result = false;

        if ($this->count == 0)
            $result = $this->pdo->beginTransaction();
        else
            $result = true;

        if ($result)
            $this->count++;

        return $result;
    }

    public function Commit() : bool {
        if ($this->count == 1)
            $result = $this->pdo->commit();
        else
            $result = true;

        if ($result)
            $this->count--;

        return $result;
    }

    public function RollBack() : bool {
        if ($this->count > 0) {
            $this->count = 0;
            return $this->pdo->rollBack();
        } else {
            return true;
        }
    }
}