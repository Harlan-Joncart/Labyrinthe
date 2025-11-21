<?php
session_start();
session_destroy(); // Réinitialiser toute partie précédente
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Labyrinthe Web</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1>Bienvenue dans le Labyrinthe Web</h1>
    <p>
        Dans ce labyrinthe, votre objectif est de collecter des clés afin d'ouvrir diverses grilles et progresser jusqu'à la sortie. <br>
        Vous pouvez récupérer plusieurs fois une même clé, mais attention : chaque grille se referme automatiquement après utilisation, <br>
        ce qui signifie que vous devrez parfois refaire un détour pour en retrouver une nouvelle.<br><br>

        Le labyrinthe peut être trompeur : il est facile de tourner en rond si l'on ne fait pas attention aux informations affichées à l'écran. <br>
        À droite de chaque bouton de déplacement (N, S, E, O pour Nord, Sud, Est, Ouest),<br> vous pouvez voir la direction exacte que vous allez prendre,
        telle qu'elle est enregistrée dans la base de donné.<br> À gauche, une indication vous précise si le couloir correspondant est libre 
        ou s'il est bloqué par une grille nécessitant une clé.<br><br>

        Observez bien toutes ces indications pour planifier vos déplacements, éviter les détours inutiles et atteindre la sortie le plus rapidement possible !
    </p>
    <form action="jeu.php" method="get">
    <button type="submit">Commencer une nouvelle partie</button>
    </form>
</body>
</html>