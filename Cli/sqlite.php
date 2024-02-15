<?php
use Provider\DataLoaderYaml;
use Provider\DataLoaderJson;

require 'Classes/autoloader.php'; 
Autoloader::register();

$loaderExtrait = new DataLoaderYaml('Data/extrait.yml');

$DB_SQLITE = 'Data' . DIRECTORY_SEPARATOR . 'db.sqlite';
$pdo = new PDO('sqlite:' . $DB_SQLITE);
switch ($argv[1]) {
    case 'create-tables':
        echo 'Création des tables ...' . PHP_EOL;
        $query = <<<EOF
            CREATE TABLE IF NOT EXISTS ARTISTE (
                idArtiste      INTEGER PRIMARY KEY AUTOINCREMENT,
                nomArtiste     TEXT NOT NULL,
                imageArtiste      TEXT
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
                imageAlbum    TEXT,
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
            
            $stmtAlbum = $pdo->prepare('
            INSERT INTO ALBUM (nomAlbum, imageAlbum, anneeSortie, idArtiste, description) 
            VALUES (:nomAlbum, :imageAlbum, :anneeSortie, :idArtiste, :description)'
            );
            
            $stmtArtiste = $pdo->prepare('
            INSERT INTO ARTISTE (nomArtiste, imageArtiste) 
            VALUES (:nomArtiste, :imageArtiste)'
            );
            
            $stmtGenre = $pdo->prepare('
            INSERT INTO GENRE (nomGenre) 
            VALUES (:nomGenre)'
            );

            $stmtPosede = $pdo->prepare('
            INSERT INTO POSSEDE (idAlbum, idGenre) 
            VALUES (:idAlbum, :idGenre)'
            );

            $artisteLoader = new DataLoaderJson('Data/artistes.json');
            $artisteData = $artisteLoader->getData();
            
            foreach ($artisteData as $artiste) {
                try {
                    $stmtArtiste->execute([
                        ':nomArtiste' => $artiste['artist'],
                        ':imageArtiste' => $artiste['img']
                    ]);
                } catch (PDOException $e) {
                    echo $e->getMessage() . PHP_EOL;
                }
            }

            $albumLoader = new DataLoaderYaml('Data/extrait.yml');
            $albumData = $albumLoader->getData();
        
            foreach ($albumData as $item) {
                $nomAlbum = isset($item['title']) ? $item['title'] : null;
                $imageAlbum = isset($item['img']) ? ($item['img'] !== null ? $item['img'] : 'default.jpg') : 'default.jpg';
                if ($imageAlbum == 'null') {
                    $imageAlbum = 'default.jpg';
                }
                $anneeSortie = isset($item['releaseYear']) ? $item['releaseYear'] : null;
                $artiste = isset($item['by']) ? $item['by'] : null;
                $genres = isset($item['genre']) ? $item['genre'] : [];
                $description = isset($item['description']) ? $item['description'] : null;

                try {
                    $stmtArtiste = $pdo->prepare('SELECT idArtiste FROM ARTISTE WHERE nomArtiste = :nomArtiste');
                    $stmtArtiste->execute([':nomArtiste' => $artiste]);
                    $idArtiste = $stmtArtiste->fetchColumn();
        
                    $stmtAlbum->execute([
                        ':nomAlbum' => $nomAlbum,
                        ':imageAlbum' => $imageAlbum,
                        ':anneeSortie' => $anneeSortie,
                        ':idArtiste' => $idArtiste,
                        ':description' => $description
                    ]);
        
                    $idAlbum = $pdo->lastInsertId();
                    
                    $stmtGenreExists = $pdo->prepare('SELECT idGenre FROM GENRE WHERE nomGenre = :nomGenre');

                    // Boucle sur chaque genre
                    foreach ($genres as $genre) {
                        if (!empty($genre)) {
                            // Exécuter la requête pour vérifier si le genre existe déjà
                            $stmtGenreExists->execute([':nomGenre' => $genre]);
                            $existingGenre = $stmtGenreExists->fetch(PDO::FETCH_ASSOC);
    
                            // Vérifier si le genre existe déjà dans la base de données
                            if ($existingGenre) {
                                // Si le genre existe déjà, récupérer son ID
                                $idGenre = $existingGenre['idGenre'];
                            } else {
                                if ($genre != " ") {
                                    // Sinon, insérer le genre dans la base de données
                                    $stmtGenre->execute([':nomGenre' => $genre]);
                                    $idGenre = $pdo->lastInsertId();
                                }
                            }
                        }
                        // Insertion de l'association entre l'album et le genre
                        $stmtPosede->execute([':idAlbum' => $idAlbum, ':idGenre' => $idGenre]);
                    } 
                } catch (PDOException $e) {
                    echo $e->getMessage() . PHP_EOL;
                }
            }
        
            $userLoader = new DataLoaderJson('Data/users.json');
            $userData = $userLoader->getData();
        
            $stmtUser = $pdo->prepare('
                INSERT INTO UTILISATEURS (pseudoUtilisateur, mailUtilisateur, mdpUtilisateur, estAdmin) 
                VALUES (:pseudoUtilisateur, :mailUtilisateur, :mdpUtilisateur, :estAdmin)'
            );
        
            foreach ($userData as $user) {
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

            $musicLoader = new DataLoaderJson('Data/music.json');
            $musicData = $musicLoader->getData();

            $stmtMusic = $pdo->prepare('
                INSERT INTO MUSIQUE (titreMusique, idAlbum) 
                VALUES (:titreMusique, :idAlbum)'
            );

            foreach ($musicData as $music) {
                try {
                    $stmtMusic->execute([
                        ':titreMusique' => $music['title'],
                        ':idAlbum' => $music['album']
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