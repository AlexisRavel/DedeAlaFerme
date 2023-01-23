<?php
    class Joueur extends User {
        public function __construct(
            private int $idUser,
            protected string $login,
            private string $mdp,
            private string $droits
        ) {
            parent::__construct($idUser, $login, $mdp, $droits);
        }

        public function lancerPartie() {
            return 1;
        }
    }
?>