<?php
$DB_SQLITE = 'Data\\db.sqlite';
$pdo = new PDO('sqlite:' . $DB_SQLITE);

function getAlbums(): array
{
    global $pdo;
    $query = <<<EOF
        SELECT idAlbum,nomAlbum,lienImage,anneeSortie
        FROM ALBUM
        ORDER BY nomAlbum
    EOF;
    $stmt = $pdo->query($query);
    return $stmt->fetchAll();
}

function getAlbumOfPlaylist(int $idUtilisateur): array
{
    global $pdo;
    $query = <<<EOF
        SELECT idAlbum,nomAlbum,lienImage,anneeSortie
        FROM ALBUM
        WHERE idAlbum IN (
            SELECT idAlbum
            FROM DANS_PLAYLIST
            WHERE idUtilisateur = :idUtilisateur
        )
        ORDER BY nomAlbum
    EOF;
    $stmt = $pdo->prepare($query);
    $stmt->execute([':idUtilisateur' => $idUtilisateur]);
    return $stmt->fetchAll();
}