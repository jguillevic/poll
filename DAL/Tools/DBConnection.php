<?php

namespace DAL\Tools;

use DAL\Tools\DBTransaction;

class DBConnection {
    /**
     * @var \PDO
     */
    private $pdo;
    /**
     * @var Transaction
     */
    private $transac;

    public function __construct() {
        $this->pdo = new \PDO(getenv("DB_ENGINE") . ":dbname=" . getenv("DB_NAME") . ";host=" . getenv("DB_SERVER"), getenv("DB_LOGIN"), getenv("DB_PASSWORD"), [ \PDO::ATTR_AUTOCOMMIT=>FALSE ]);
        $this->transac = new DBTransaction($this->pdo);
    }

    public function BeginTransac() : bool {
        return $this->transac->Begin();
    }

    public function CommitTransac() : bool {
        return $this->transac->Commit();
    }

    public function RollBackTransac() : bool {
        return $this->transac->RollBack();
    }

    public function Execute(string $query, array $params) : bool {
        $st = $this->pdo->prepare($query);
        return $st->execute($params);
    }

    public function FetchAll(string $query, array $params) : array {
        $st = $this->pdo->prepare($query);
        $st->execute($params);
        return $st->fetchAll();
    }

    public function GetLastInsertId() : string {
        return $this->pdo->lastInsertId();
    }
}