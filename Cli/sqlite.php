<?php
$DB_SQLITE = 'Data\\db.sqlite';
$pdo = new PDO('sqlite:' . $DB_SQLITE);

switch ($argv[1]) {
    case 'create-tables':
        echo 'Création des tables ...' . PHP_EOL;
        $query = <<<EOF
            CREATE TABLE IF NOT EXISTS UTILISATEURS (
                idUtilisateur       INTEGER PRIMARY KEY AUTOINCREMENT,
                pseudoUtilisateur   TEXT NOT NULL,
                mailUtilisateur     TEXT NOT NULL,
                mdpUtilisateursss      TEXT NOT NULL
            );

            CREATE TABLE IF NOT EXISTS ALBUM (
                idAlbum      INTEGER PRIMARY KEY AUTOINCREMENT,
                nomAlbum     TEXT NOT NULL,
                lienImage    TEXT,
                anneeSortie   DATE NOT NULL
            );

            CREATE TABLE IF NOT EXISTS DANS_PLAYLIST (
                idUtilisateur   INTEGER NOT NULL,
                idAlbum         INTEGER NOT NULL,
                note            INTEGER NOT NULL,
                playlist        BOOLEAN NOT NULL,
                PRIMARY KEY (idUtilisateur, idAlbum),
                FOREIGN KEY (idUtilisateur) REFERENCES UTILISATEURS(idUtilisateur),
                FOREIGN KEY (idAlbum) REFERENCES ALBUM(idAlbum)
            );

            CREATE TABLE IF NOT EXISTS GENRE (
                idGenre      INTEGER PRIMARY KEY AUTOINCREMENT,
                nomGenre     TEXT NOT NULL
            );

            CREATE TABLE IF NOT EXISTS POSSEDE (
                idAlbum      INTEGER NOT NULL,
                idGenre      INTEGER NOT NULL,
                PRIMARY KEY (idAlbum, idGenre),
                FOREIGN KEY (idAlbum) REFERENCES ALBUM(idAlbum),
                FOREIGN KEY (idGenre) REFERENCES GENRE(idGenre)
            );

            CREATE TABLE IF NOT EXISTS ARTIST (
                idArtiste      INTEGER PRIMARY KEY AUTOINCREMENT,
                nomArtiste     TEXT NOT NULL,
                lienImage      TEXT NOT NULL
            );
        EOF;
        $pdo->exec($query);
        echo 'Tables créées !' . PHP_EOL;
        break;
    
    case 'load-data':
        echo 'Insertion des données ...' . PHP_EOL;

        $command = 'python -c "import sys, yaml, json; json.dump(yaml.safe_load(sys.stdin), sys.stdout)" < Data/extrait.yml';
        $json = shell_exec($command);
        $data = json_decode($json, true);
        $query = null;
        $stmt = $pdo->prepare('
            INSERT INTO ALBUM (idAlbum, nomAlbum, lienImage, anneeSortie) 
            VALUES (:idAlbum, :nomAlbum, :lienImage, :anneeSortie)'
        );
        
        foreach ($data as $data) {
            if ($data['img'] == null) {
                try {
                    $stmt->execute([
                        ':idAlbum' => $data['entryId'],
                        ':nomAlbum' => $data['title'],
                        ':lienImage' => 'default.jpg',
                        ':anneeSortie' => $data['releaseYear']
                    ]);
                } catch (PDOException $e) {
                    echo $e->getMessage() . PHP_EOL;
                }
            } else {
                try {
                    $stmt->execute([
                        ':idAlbum' => $data['entryId'],
                        ':nomAlbum' => $data['title'],
                        ':lienImage' => $data['img'],
                        ':anneeSortie' => $data['releaseYear']
                    ]);
                } catch (PDOException $e) {
                    echo $e->getMessage() . PHP_EOL;
                }
            }
        }

        echo 'Données insérées!'. PHP_EOL;
        break;
    case 'delete-tables':
        echo 'Suppression des tables ...' . PHP_EOL;
        $query = <<<EOF
            DROP TABLE IF EXISTS UTILISATEURS;
            DROP TABLE IF EXISTS ALBUM;
            DROP TABLE IF EXISTS DANS_PLAYLIST;
            DROP TABLE IF EXISTS GENRE;
            DROP TABLE IF EXISTS POSSEDE;
            DROP TABLE IF EXISTS ARTIST;
        EOF;
        $pdo->exec($query);
        echo 'Tables supprimées !' . PHP_EOL;
        break;
}

?>