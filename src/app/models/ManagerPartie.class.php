<?php
    namespace src\app\models;

    class ManagerPartie {
        public function __construct(
            private array $tabPartieJoueur = array(),
            private int $cptPartie = 0
        ) {}

        public function __get($name) {
            return match($name) {
                "tabPartieJoueur" => $this->tabPartieJoueur,
                "cptPartie" => $this->cptPartie
            };
        }

        public function __set($name, $value){
            match($name) {
                "tabPartieJoueur" => $this->tabPartieJoueur=$value,
                "cptPartie" => $this->cptPartie=$value
            };
        }

        public function nouvellePartie(array $lstJoueurs, Jeu $jeu) {
            // on définit le numéro de partie
            $this->cptPartie++;

            // Création d'une date pour la partie
            $date = new \DateTime('now', new \DateTimeZone("Europe/Paris"));

            // On ajoute à tous les joueurs la partie
            /*$plusGrandScore = 0;
            $joueurGagnant = null;*/

            // génération de la partie avec l'id = numéro de partie (cptPartie) pour chaque concurrent
            // un concurrent joue à la même partie que les autres concurrents
            // this->concurrent correspond à la liste des joueurs à inscrire pour la partie
            for($i=0; $i<count($lstJoueurs); $i++) {

                $partie = new Partie($this->cptPartie, $date, $jeu, $lstJoueurs[$i]);
                
                // Indirect Modification of Overloaded Property
                /*$parties = $this->concurrent[$i]->parties;
                $parties[] = $partie;
                $this->concurrent[$i]->parties = $parties;

                $temp = $this->jeu->parties;
                $temp[] = $partie;
                $this->jeu->parties = $temp;

                
                $resultat = $partie->jeu->lancerDes();
                $partie->score = $resultat["Score"];
                $partie->historique = $resultat["Historique"];

                if($resultat["Score"] > $plusGrandScore) {
                    $plusGrandScore = $resultat["Score"];
                    $joueurGagnant = $this->concurrent[$i];
                }*/
                $this->tabPartieJoueur[] = $partie;

            }

            // Definir gagnant
           // $joueurGagnant->parties[count($joueurGagnant->parties)-1]->gagnant = TRUE;
        }

        public function jouerPartie()
        {
            foreach($this->tabPartieJoueur as $unePartieDUnJoueur) {
                $unePartieDUnJoueur->jeu->jouerTour($unePartieDUnJoueur) ;
            }

        }
        
    }
?>