<?php
/*
    - Init deux joueurs
    - Lancer une partie
    - Aff le result de chaque lancer des joueurs
    - Aff gagnant
*/
    include("src/app/models/JeuBateau.class.php");
    include("src/app/models/Joueur.class.php");

    $tabJoueurs = [];
    
    // Init des joueurs
    $user1 = new User(1, "Joueur1", "megaMdp", "aucun");
    $user2 = new User(2, "Joueur2", "lemdp", "aucun");
    $tabJoueurs[] = $j1 = $user1->inscription();
    $tabJoueurs[] = $j2 = $user2->inscription();
    echo "<p>$j1</p>";
    echo "<p>$j2</p>";
    
    // Init des jeux
    $megaJeu = new JeuBateau();

    $j1->lancerPartie($j1, $tabJoueurs, $megaJeu);

    echo $j1->parties[0];
?>
