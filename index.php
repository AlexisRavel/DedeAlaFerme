<?php
/*
    - Init deux joueurs
    - Lancer une partie
    - Aff le result de chaque lancer des joueurs
    - Aff gagnant
*/
    include("src/app/models/JeuBateau.class.php");
    include("src/app/models/Joueur.class.php");

    // Init des joueurs
    $j1 = new Joueur(1, "Joueur1", "megaMdp", "aucun");
    $j2 = new Joueur(2, "Joueur2", "lemdp", "aucun");

    $j1->lancerPartie();

    echo "<p>$j1</p>";
    echo "<p>$j2</p>";


?>