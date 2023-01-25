<?php
    namespace src\app\models;

    abstract class Jeu {
        public function __construct(
            protected string $regles,
            protected array $parties = []
        ) {}

        public function __get($name) {
            return match($name) {
                "regles" => $this->regles,
                "parties" => $this->parties
            };
        }

        public function __set($name, $value){
            match($name) {
                "regles" => $this->regles=$value,
                "parties" => $this->parties=$value
            };
        }

        // TO DO
        // Aff le classement des gagnants de toutes les parties ->  login : score
        public function affClassement() {
            return 1;
        }

        // TO DO
        // Aff les trois meilleurs joueurs
        public function top3() {
            return 1;
        }

        public function __toString() {
            return "Regles: ".$this->regles;
        }
    }
?>