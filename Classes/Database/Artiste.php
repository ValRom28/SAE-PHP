<?php
namespace Database;

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

    public function createArtiste($nomArtiste, $lienImage) {
        $query = <<<EOF
        INSERT INTO artiste (nomArtiste, lienImage)
        VALUES (:nomArtiste, :lienImage)
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':nomArtiste' => $nomArtiste,
            ':lienImage' => $lienImage,
        ]);
    }

    public function updateArtiste($idArtiste, $nomArtiste, $lienImage) {
        $query = <<<EOF
        UPDATE artiste
        SET nomArtiste = :nomArtiste, lienImage = :lienImage
        WHERE idArtiste = :idArtiste
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':idArtiste' => $idArtiste,
            ':nomArtiste' => $nomArtiste,
            ':lienImage' => $lienImage,
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

    public function getArtisteById($idArtiste) {
        $stmt = $this->pdo->prepare("SELECT * FROM ARTISTE WHERE idArtiste = ?");
        $stmt->execute([$idArtiste]);
        return $stmt->fetchAll();
    }

    public function possedeAlbum($idArtiste) {
        $query = <<<EOF
            SELECT * FROM ALBUM
            WHERE idArtiste = :idArtiste
        EOF;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':idArtiste' => $idArtiste]);
        return $stmt->fetchAll();
    }
    public  function afficherArtistes(){
        $stmt = $this->pdo->prepare("SELECT * FROM artiste");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>