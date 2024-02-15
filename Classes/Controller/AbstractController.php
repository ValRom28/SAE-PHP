<?php
namespace Controller;

abstract class AbstractController {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }
}

?>
