<?php
    abstract class Jeu {
        public function __construct(
            private string $regles
        ) {}

        // Aff le classement des gagnants de toutes les parties ->  login : score
        public function affClassement() {
            return 1;
        }

        // Aff les trois meilleurs joueurs
        public function top3() {
            return 1;
        }
    }
?>