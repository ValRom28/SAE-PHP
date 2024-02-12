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
                mdpUtilisateur      TEXT NOT NULL
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

        // Préparation de la requête d'insertion pour les albums
        $stmtAlbum = $pdo->prepare('
            INSERT INTO ALBUM (nomAlbum, lienImage, anneeSortie) 
            VALUES (:nomAlbum, :lienImage, :anneeSortie)'
        );
        $stmArtiste = $pdo->prepare('
            INSERT INTO ARTIST (nomArtiste, lienImage)
            VALUES (:nomArtiste, :lienImage)'
        );
        $stmtPosede = $pdo->prepare('
            INSERT INTO POSSEDE (idAlbum, idGenre)
            VALUES (:idAlbum, :idGenre)'
        );
        

        // Préparation de la requête d'insertion pour les utilisateurs
        $command = 'python -c "import sys, yaml, json; json.dump(yaml.safe_load(sys.stdin), sys.stdout)" < Data/Utilisateurs.yml';
        $json = shell_exec($command);
        $data2 = json_decode($json, true);
        $stmtUser = $pdo->prepare('
            INSERT INTO UTILISATEURS (pseudoUtilisateur, mailUtilisateur, mdpUtilisateur) 
            VALUES (:pseudoUtilisateur, :mailUtilisateur, :mdpUtilisateur)'
        );

        $command = 'python -c "import sys, yaml, json; json.dump(yaml.safe_load(sys.stdin), sys.stdout)" < Data/genre.yml';
        $json = shell_exec($command);
        $data3 = json_decode($json, true);
        $stmGenre = $pdo->prepare('
            INSERT INTO GENRE (nomGenre)
            VALUES (:nomGenre)');
        
        

        // Insertion des données des utilisateurs
        foreach ($data2['utilisateurs'] as $user) {
            try {
                $stmtUser->execute([
                    ':pseudoUtilisateur' => $user['pseudoUtilisateur'],
                    ':mailUtilisateur' => $user['mailUtilisateur'],
                    ':mdpUtilisateur' => $user['mdpUtilisateur']
                ]);
            } catch (PDOException $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }
        foreach ($data3 as $genre) {
            try {
                $stmGenre->execute([':nomGenre' => $genre['nomGenre']]);
            } catch (PDOException $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }

        foreach ($data as $item) {
            // Vérification de l'existence des clés
            $nomAlbum = isset($item['title']) ? $item['title'] : null;
            $lienImage = isset($item['img']) ? $item['img'] : 'default.jpg';
            $anneeSortie = isset($item['releaseYear']) ? $item['releaseYear'] : null;
            $artiste= isset($item['by']) ? $item['by'] : null;
            $lienImageArtiste =  'default.jpg';
            $genres = isset($item['genre']) ? $item['genre'] : [];
            

            // Insertion des données des albums
            try {
                $stmtAlbum->execute([
                    ':nomAlbum' => $nomAlbum,
                    ':lienImage' => $lienImage,
                    ':anneeSortie' => $anneeSortie
                ]);
                $stmtArtisteExists = $pdo->prepare('SELECT idArtiste FROM ARTIST WHERE nomArtiste = :nomArtiste');
                $stmtArtisteExists->execute([':nomArtiste' => $artiste]);
                $existingArtiste = $stmtArtisteExists->fetch(PDO::FETCH_ASSOC);
                if (!$existingArtiste) {
                    $stmArtiste->execute([
                        ':nomArtiste' => $artiste,
                        ':lienImage' => $lienImageArtiste
                    ]);
                }

                $idAlbum = $pdo->lastInsertId();

        // Insertion des genres associés à l'album
        foreach ($genres as $genre) {
            // Vérifier si le genre existe déjà dans la base de données
            $stmGenre->execute([':nomGenre' => $genre]);
            $existingGenre = $stmGenre->fetch(PDO::FETCH_ASSOC);
        
            if ($existingGenre) {
                // Si le genre existe déjà, récupérer son ID
                $idGenre = $existingGenre['idGenre'];
            } else {
                // Sinon, insérer le genre dans la base de données
                $stmGenre->execute([':nomGenre' => $genre]);
                $idGenre = $pdo->lastInsertId();
            }
        
            // Insertion de l'association entre l'album et le genre
            $stmtPosede->execute([':idAlbum' => $idAlbum, ':idGenre' => $idGenre]);
        }
        
            } catch (PDOException $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }
      
        

        echo 'Données insérées!' . PHP_EOL;
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