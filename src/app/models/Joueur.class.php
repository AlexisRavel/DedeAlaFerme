<?php
    include("User.class.php");
    include("Partie.class.php");

    class Joueur extends User {
        public function __construct(
            private int $idUser,
            protected string $login,
            private string $mdp,
            private string $droits,
            private array $parties
        ) {
            parent::__construct($idUser, $login, $mdp, $droits);
        }

        public function lancerPartie() {
            $partie = new Partie("maintenant");
        }
    }
?>