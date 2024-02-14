<?php
$DB_SQLITE = 'Data\\db.sqlite';
$pdo = new PDO('sqlite:' . $DB_SQLITE);
switch ($argv[1]) {
    case 'create-tables':
        echo 'Création des tables ...' . PHP_EOL;
        $query = <<<EOF
            CREATE TABLE IF NOT EXISTS ARTISTE (
                idArtiste      INTEGER PRIMARY KEY AUTOINCREMENT,
                nomArtiste     TEXT NOT NULL,
                lienImage      TEXT
            );
            
            CREATE TABLE IF NOT EXISTS UTILISATEURS (
                idUtilisateur       INTEGER PRIMARY KEY AUTOINCREMENT,
                pseudoUtilisateur   TEXT NOT NULL,
                mailUtilisateur     TEXT NOT NULL,
                mdpUtilisateur      TEXT NOT NULL,
                estAdmin            BOOLEAN DEFAULT 0
            );

            CREATE TABLE IF NOT EXISTS ALBUM (
                idAlbum      INTEGER PRIMARY KEY AUTOINCREMENT,
                nomAlbum     TEXT NOT NULL,
                lienImage    TEXT,
                anneeSortie  DATE NOT NULL,
                idArtiste    INTEGER NOT NULL,
                description  TEXT,
                FOREIGN KEY (idArtiste) REFERENCES ARTISTE(idArtiste)
            );

            CREATE TABLE IF NOT EXISTS DANS_PLAYLIST (
                idUtilisateur   INTEGER NOT NULL,
                idAlbum         INTEGER NOT NULL,
                note            INTEGER DEFAULT NULL,
                inPlaylist      BOOLEAN DEFAULT 0,
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

            CREATE TABLE IF NOT EXISTS MUSIQUE (
                idMusique       INTEGER PRIMARY KEY AUTOINCREMENT,
                titreMusique    TEXT NOT NULL,
                idAlbum         INTEGER NOT NULL,
                FOREIGN KEY (idAlbum) REFERENCES ALBUM(idAlbum)
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
            INSERT INTO ALBUM (nomAlbum, lienImage, anneeSortie,idArtiste, description) 
            VALUES (:nomAlbum, :lienImage, :anneeSortie,:idArtiste, :description)'
        );
        $stmArtiste = $pdo->prepare('
            INSERT INTO ARTISTE (nomArtiste, lienImage)
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
            INSERT INTO UTILISATEURS (pseudoUtilisateur, mailUtilisateur, mdpUtilisateur,estAdmin) 
            VALUES (:pseudoUtilisateur, :mailUtilisateur, :mdpUtilisateur,:estAdmin)'
        );
        $stmGenre = $pdo->prepare('
            INSERT INTO GENRE (nomGenre)
            VALUES (:nomGenre)');
        
        $command = 'python -c "import sys, yaml, json; json.dump(yaml.safe_load(sys.stdin), sys.stdout)" < Data/music.yml';
        $json = shell_exec($command);
        $data3 = json_decode($json, true);
        $stmtMusique = $pdo->prepare('
            INSERT INTO MUSIQUE (titreMusique, idAlbum)
            VALUES (:titreMusique, :idAlbum)'
        );

        // Insertion des données des utilisateurs
        foreach ($data2['utilisateurs'] as $user) {
            try {
                $stmtUser->execute([
                    ':pseudoUtilisateur' => $user['pseudoUtilisateur'],
                    ':mailUtilisateur' => $user['mailUtilisateur'],
                    ':mdpUtilisateur' => $user['mdpUtilisateur'],
                    ':estAdmin' => isset($user['estAdmin']) ? $user['estAdmin'] : 0
                ]);
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
            $description = isset($item['description']) ? $item['description'] : null;
            

            // Insertion des données des albums
            try {
                
                // Vérifier si l'artiste existe déjà dans la base de données
                    $stmtArtisteExists = $pdo->prepare('SELECT idArtiste FROM ARTISTE WHERE nomArtiste = :nomArtiste');
                    $stmtArtisteExists->execute([':nomArtiste' => $artiste]);
                    $existingArtiste = $stmtArtisteExists->fetch(PDO::FETCH_ASSOC);

                    // Si l'artiste n'existe pas, l'insérer dans la table ARTIST
                    if (!$existingArtiste) {
                        $stmArtiste->execute([
                            ':nomArtiste' => $artiste,
                            ':lienImage' => $lienImageArtiste
                        ]);
                        // Récupérer l'ID de l'artiste nouvellement inséré
                        $idArtiste = $pdo->lastInsertId();
                    } else {
                        // Si l'artiste existe déjà, récupérer son ID
                        $idArtiste = $existingArtiste['idArtiste'];
                    }

                    // Insérer l'album dans la table ALBUM en utilisant l'ID de l'artiste
                    $stmtAlbum->execute([
                        ':nomAlbum' => $nomAlbum,
                        ':lienImage' => $lienImage,
                        ':anneeSortie' => $anneeSortie,
                        ':idArtiste' => $idArtiste
                    ]);

                    // Récupérer l'ID de l'album nouvellement inséré
                    $idAlbum = $pdo->lastInsertId();
                // Préparer la requête pour vérifier l'existence du genre
                $stmGenreExists = $pdo->prepare('SELECT idGenre FROM GENRE WHERE nomGenre = :nomGenre');

                // Boucle sur chaque genre
                foreach ($genres as $genre) {
                    // Exécuter la requête pour vérifier si le genre existe déjà
                    $stmGenreExists->execute([':nomGenre' => $genre]);
                    $existingGenre = $stmGenreExists->fetch(PDO::FETCH_ASSOC);

                    // Vérifier si le genre existe déjà dans la base de données
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

        }

        
             catch (PDOException $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        
        }
        foreach ($data3 as $item) {
            // Vérification de l'existence des clés
            $titreMusique = isset($item['title']) ? $item['title'] : null;
            $idAlbum = isset($item['album']) ? $item['album'] : null;
            // Insertion des données des musiques
            try {
                $stmtMusique->execute([
                    ':titreMusique' => $titreMusique,
                    ':idAlbum' => $idAlbum
                ]);
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
            DROP TABLE IF EXISTS ARTISTE;
            DROP TABLE IF EXISTS MUSIQUE;
        EOF;
        $pdo->exec($query);
        echo 'Tables supprimées !' . PHP_EOL;
        break;
}
?>