<?php
session_start();
$score = $_SESSION['deplacements'] ?? 0;
session_destroy();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Victoire !</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: #0b0b0b;
            color: white;
            overflow: hidden;
            animation: fadeIn 1.5s ease forwards;
        }

        h1 {
            font-size: 3em;
            margin-top: 60px;
            animation: pop 1s ease forwards;
        }

        p {
            font-size: 1.4em;
            opacity: 0;
            animation: slideUp 1.2s ease forwards 0.5s;
        }

        .btn {
            display: inline-block;
            margin-top: 40px;
            padding: 12px 25px;
            background: #ffcc00;
            color: #000;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
            opacity: 0;
            animation: slideUp 1.2s ease forwards 1s;
        }

        .btn:hover {
            background: #ffe066;
            transform: scale(1.05);
        }

        /* --- CONFETTIS --- */
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            top: -10px;
            background: red;
            animation: fall 3s linear infinite;
            opacity: 0.9;
        }

        @keyframes fall {
            0% { transform: translateY(0) rotate(0); }
            100% { transform: translateY(110vh) rotate(360deg); }
        }

        /* --- ANIMATIONS TEXTE --- */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes pop {
            0% { transform: scale(0.4); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes slideUp {
            0% { transform: translateY(40px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>

<body>

    <!-- Confettis générés en JS -->
    <script>
        for (let i = 0; i < 30; i++) {
            const confetti = document.createElement("div");
            confetti.classList.add("confetti");

            // Couleurs aléatoires
            confetti.style.backgroundColor =
                ["#ff4757", "#ffa502", "#2ed573", "#1e90ff", "#eccc68"][Math.floor(Math.random() * 5)];

            // Position horizontale aléatoire
            confetti.style.left = Math.random() * 100 + "vw";

            // Durée différente pour effet naturel
            confetti.style.animationDuration = (2 + Math.random() * 2) + "s";

            document.body.appendChild(confetti);
        }
    </script>

    <h1>🎉 Félicitations ! 🎉</h1>
    <p>Vous avez trouvé la sortie du labyrinthe.</p>
    <p>Score final : <strong><?= $score ?></strong> déplacements</p>

    <a href="index.php" class="btn">Retourner au menu principal</a>

</body>
</html>

