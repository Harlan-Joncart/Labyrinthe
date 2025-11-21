<?php

// Couloir de départ
function getDepart($sqlite) {
    $sql = "SELECT * FROM couloir WHERE type = 'depart' LIMIT 1";
    return $sqlite->query($sql)->fetchArray(SQLITE3_ASSOC);
}

// Info couloir
function getCouloir($sqlite, $id) {
    $sql = "SELECT * FROM couloir WHERE id = :id";
    $req = $sqlite->prepare($sql);
    $req->bindValue(':id', $id, SQLITE3_INTEGER);
    return $req->execute()->fetchArray(SQLITE3_ASSOC);
}

// Couloirs adjacents
function getAdjacents($sqlite, $id) {
    $sql = "
        SELECT c2.id, c2.type, l.position2 AS position, l.type AS passage_type
        FROM passage l
        JOIN couloir c1 ON l.couloir1 = c1.id
        JOIN couloir c2 ON l.couloir2 = c2.id
        WHERE c1.id = :id
        UNION
        SELECT c1.id, c1.type, l.position1 AS position, l.type AS passage_type
        FROM passage l
        JOIN couloir c1 ON l.couloir1 = c1.id
        JOIN couloir c2 ON l.couloir2 = c2.id
        WHERE c2.id = :id;
    ";
    $req = $sqlite->prepare($sql);
    $req->bindValue(':id', $id, SQLITE3_INTEGER);
    return $req->execute();
}

// Score
function getScore() {
    return $_SESSION['deplacements'] ?? 0;
}

// Ramasser une clé
function ramasserCle($couloir) {
    if ($couloir['type'] === 'cle') {
        if (!isset($_SESSION['cles'])) $_SESSION['cles'] = 0;
        $_SESSION['cles']++;
        $_SESSION['message'] = "Vous avez trouvé une clé ! Vous avez maintenant {$_SESSION['cles']} clé(s).";
    }
}

// Vérifier si passage possible
function peutPasser($passage) {
    if ($passage['passage_type'] === 'grille') {
        return ($_SESSION['cles'] ?? 0) > 0;
    }
    return true;
}

// Consommer une clé lors du passage d'une grille
function consommerCleSiNecessaire($passage) {
    if ($passage['passage_type'] === 'grille') {
        $_SESSION['cles']--;
        $_SESSION['message'] = "Vous avez utilisé une clé pour ouvrir une grille. Il vous reste {$_SESSION['cles']} clé(s).";
    }
}

?>
