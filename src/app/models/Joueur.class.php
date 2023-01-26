<?php
    namespace src\app\models;

    class Joueur extends User {
        public function __construct(
            private int $idUser,
            protected string $login,
            private string $mdp,
            private string $droits,
            private array $parties = []
        ) {
            parent::__construct($idUser, $login, $mdp, $droits);
        }

        public function __get($name) {
            return match($name) {
                "idUser" => $this->idUser,
                "login" => $this->login,
                "mdp" => $this->mdp,
                "droits" => $this->droits,
                "parties" => $this->parties
            };
        }

        public function __set($name, $value){
            match($name) {
                "idUser" => $this->idUser=$value,
                "login" => $this->login=$value,
                "mdp" => $this->mdp=$value,
                "droits" => $this->droits=$value,
                "parties" => $this->parties=$value
            };
        }

        public function lancerPartie($j1, $tabJoueurs, $nbJoueur, $jeu) {
            // Prends d'autres joueurs au hasard
            $joueursConcurrent = [$j1];
            for($i=1; $i<$nbJoueur; $i++) {
                $joueurRandom = $tabJoueurs[random_int(0, count($tabJoueurs)-1)];
                while(in_array($joueurRandom, $joueursConcurrent)) {
                    $joueurRandom = $tabJoueurs[random_int(0, count($tabJoueurs)-1)];
                }
                $joueursConcurrent[] = $joueurRandom;
            }

            // Création d'une partie
            $date = new \DateTime('now', new \DateTimeZone("Europe/Paris"));
            $partie = new Partie($date, [], $jeu, $joueursConcurrent);
            $parties = $jeu->parties;
            $parties[] = $partie;
            $jeu->parties = $parties;

            // On ajoute à tous les joueurs la partie
            for($i=0; $i<count($joueursConcurrent); $i++) {
                $joueursConcurrent[$i]->parties[] = $partie;
            }
            
            // Tous les joueurs lancent les dés
            for($i=0; $i<count($partie->joueurs); $i++) {
                $jeu->lancerDes();
            }
            $partie->definirGagnant();
        }

        public function __toString() {
            $aff = parent::__toString();
            return $aff;
        }
    }
?>