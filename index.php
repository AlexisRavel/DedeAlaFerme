<?php
/*
    - Init deux joueurs
    - Lancer une partie
    - Aff le result de chaque lancer des joueurs
    - Aff gagnant
*/
    namespace src\app\models;
    require("autoload.php");

    // Init des joueurs
    $tabJoueurs = [];
    $tabJoueurs[] = $j1 = new Joueur(1, "Joueur1", "megaMdp", "aucun");
    $tabJoueurs[] = $j2 = new Joueur(2, "Joueur2", "lemdp", "aucun");
    $tabJoueurs[] = $j3 = new Joueur(3, "Joueur3", "ui", "aucun");
    $tabJoueurs[] = $j4 = new Joueur(4, "Joueur4", "1234", "aucun");
    
    // Init des jeux
    $megaJeu = new JeuBateau("Lancer les dés", [], 5, 3, [], []);
    
    if(isset($_POST["affichage"]) && $_POST["affichage"] == "Lancer") {
        $nbJoueur = $_POST["nbJoueurs"];
        $j1->lancerPartie($j1, $tabJoueurs, $nbJoueur, $megaJeu);
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dede</title>
</head>
<body>
    <h1>Dede À La Ferme</h1>

    <?php
        if(empty($_POST) || $_POST["affichage"] == "Retour") {
            // Page d'accueil
    ?>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <input type="submit" name="affichage" value="Joueurs">
                <input type="submit" name="affichage" value="Bateau">
            </form>
    <?php
        } elseif(isset($_POST["affichage"]) && $_POST["affichage"] == "Joueurs") {
            // Page d'affichage des joueurs
            for($i=0; $i<count($tabJoueurs); $i++) {
                echo "<p>".$tabJoueurs[$i]->login."</p>";
            }   
    ?>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <input type="submit" name="affichage" value="Retour">
            </form>
    <?php
        } elseif(isset($_POST["affichage"]) && $_POST["affichage"] == "Bateau") {
            // Page d'affichage des jeux
            echo "<p>".$megaJeu."</p>";
    ?>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <input type="number" name="nbJoueurs" min="2" max="4" value="2">
                <input type="submit" name="affichage" value="Lancer">
                <input type="submit" name="affichage" value="Retour">
            </form>
    <?php
        } elseif(isset($_POST["affichage"]) && $_POST["affichage"] == "Lancer") {
            // Page d'affichage des jeux
            echo "<p>".$j1->parties[0]."</p>";
    ?>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <input type="number" name="nbJoueurs" min="2" max="4" value="2">
                <input type="submit" name="affichage" value="Lancer">
                <input type="submit" name="affichage" value="Retour">
            </form>
    <?php
        }
    ?>
</body>
</html>