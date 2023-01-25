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
    $user1 = new User(1, "Joueur1", "megaMdp", "aucun");
    $user2 = new User(2, "Joueur2", "lemdp", "aucun");
    $user3 = new User(3, "Joueur3", "ui", "aucun");
    $user4 = new User(4, "Joueur4", "1234", "aucun");
    $tabJoueurs[] = $j1 = $user1->inscription();
    $tabJoueurs[] = $j2 = $user2->inscription();
    $tabJoueurs[] = $j3 = $user3->inscription();
    $tabJoueurs[] = $j4 = $user4->inscription();
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
