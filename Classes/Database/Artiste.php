<?php

class Artiste {
    private $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function artisteExist($nomArtiste) {
        $stmt = $this->pdo->prepare("SELECT * FROM ARTISTE WHERE nomArtiste = ?");
        $stmt->execute([$nomArtiste]);
        return $stmt->fetch();
    }

    public function createArtiste($nomArtiste, $lienImage, $description) {
        $query = <<<EOF
        INSERT INTO artiste (nomArtiste, lienImage, description)
        VALUES (:nomArtiste, :lienImage, :description)
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':nomArtiste' => $nomArtiste,
            ':lienImage' => $lienImage,
            ':description' => $description
        ]);
    }

    public function updateArtiste($idArtiste, $nomArtiste, $lienImage, $description) {
        $query = <<<EOF
        UPDATE artiste
        SET nomArtiste = :nomArtiste, lienImage = :lienImage, description = :description
        WHERE idArtiste = :idArtiste
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':idArtiste' => $idArtiste,
            ':nomArtiste' => $nomArtiste,
            ':lienImage' => $lienImage,
            ':description' => $description
        ]);
    }

    public function deleteArtiste($idArtiste) {
        $query = <<<EOF
        DELETE FROM artiste
        WHERE idArtiste = :idArtiste
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idArtiste' => $idArtiste]);
    }

    public function getArtistes(): array {
        $stmt = $this->pdo->query("SELECT * FROM ARTISTE");
        return $stmt->fetchAll();
    }
}

?>