<?php
/*
    - Init deux joueurs
    - Lancer une partie
    - Aff le result de chaque lancer des joueurs
    - Aff gagnant
*/
    namespace src\app\models;
    require("autoload.php");

    $tabJoueurs = [];
    
    // Init des joueurs
    $tabJoueurs[] = $j1 = new Joueur(1, "Joueur1", "megaMdp", "aucun");
    $tabJoueurs[] = $j2 = new Joueur(2, "Joueur2", "lemdp", "aucun");
    $tabJoueurs[] = $j3 = new Joueur(3, "Joueur3", "ui", "aucun");
    $tabJoueurs[] = $j4 = new Joueur(4, "Joueur4", "1234", "aucun");
    echo "<p>$j1</p>";
    echo "<p>$j2</p>";
    echo "<p>$j3</p>";
    echo "<p>$j4</p>";
    
    // Init des jeux
    $megaJeu = new JeuBateau();
    $nbJoueur = 4;

    $j1->lancerPartie($j1, $tabJoueurs, $nbJoueur,$megaJeu);
    echo $j1->parties[0];
?>

