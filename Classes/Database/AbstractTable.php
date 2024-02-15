<?php
namespace Database;

abstract class AbstractTable {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }
}

?>
