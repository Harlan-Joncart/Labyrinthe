<?php
// Connexion à la base SQLite
$bdd_fichier = __DIR__ . '/../labyrinthe.db';

try {
    $sqlite = new SQLite3($bdd_fichier);
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
