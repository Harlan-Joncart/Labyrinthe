<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'includes/connexion.php';
include 'includes/fonctions.php';

// Initialisation
if (!isset($_SESSION['deplacements'])) $_SESSION['deplacements'] = 0;

// ID du couloir actuel
if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    // On veut vérifier quel passage a été utilisé
    if (isset($_GET['from'])) {
        $from = intval($_GET['from']);

        // récupération du passage
        $adj = getAdjacents($sqlite, $from);

        while ($p = $adj->fetchArray(SQLITE3_ASSOC)) {
            if ($p['id'] == $id) {

                // passage grille → consommer une clé
                if ($p['passage_type'] === 'grille' && peutPasser($p)) {
                    consommerCleSiNecessaire($p);
                }
                break;
            }
        }
    }

} else {
    $depart = getDepart($sqlite);
    if (!$depart) die("Aucun couloir de départ trouvé !");
    $id = $depart['id'];
}

// Récupération du couloir
$couloir = getCouloir($sqlite, $id);
if (!$couloir) die("Ce couloir n'existe pas.");

// Incrémenter déplacements
if ($couloir['type'] !== 'depart') {
    $_SESSION['deplacements']++;
}

// Ramasser clé
ramasserCle($couloir);

// Sortie
if ($couloir['type'] === 'sortie') {
    header("Location: fin.php");
    exit;
}

// Sorties adjacentes
$adjacents = getAdjacents($sqlite, $id);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Couloir <?= $couloir['id'] ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1>Couloir <?= $couloir['id'] ?> (<?= htmlspecialchars($couloir['type']) ?>)</h1>
    <p>Déplacements effectués : <?= getScore() ?></p>
    <p>Clés en poche : <?= $_SESSION['cles'] ?? 0 ?></p>

    <?php if (!empty($_SESSION['message'])): ?>
        <p><?= $_SESSION['message'] ?></p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <h2>Sorties possibles :</h2>
    <ul>
        <?php while ($adj = $adjacents->fetchArray(SQLITE3_ASSOC)): ?>
            <li>
                <?= ucfirst($adj['position']) ?> → 
                <form action="jeu.php" method="get" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $adj['id'] ?>">
                    <input type="hidden" name="from" value="<?= $couloir['id'] ?>">

                    <?php if (!peutPasser($adj)): ?>
                        <button type="submit" disabled>Grille verrouillée</button>
                    <?php else: ?>
                        <button type="submit">Aller au couloir <?= $adj['id'] ?></button>
                    <?php endif; ?>
                </form>

                (<?= htmlspecialchars($adj['passage_type']) ?>)
            </li><br>
        <?php endwhile; ?>
    </ul>

    <form action="index.php" method="get">
        <button type="submit">Abandonner la partie</button>
    </form>

</body>
</html>

<?php $sqlite->close(); ?>
