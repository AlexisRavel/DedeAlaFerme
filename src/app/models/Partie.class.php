<?php
    namespace src\app\models;

    class Partie {
        public function __construct(
            private int $idPartie,
            private \DateTime $datePartie,
            private Jeu $jeu,
            private Joueur $joueur,
            private int $score = 0,
            private array $historique = array(),
            private bool $gagnant = TRUE
        ) {}

        public function __get($name) {
            return match($name) {
                "idPartie" => $this->idPartie,
                "datePartie" => $this->datePartie,
                "jeu" => $this->jeu,
                "joueur" => $this->joueur,
                "score" => $this->score,
                "historique" => $this->historique,
                "gagnant" => $this->gagnant
            };
        }

        public function __set($name, $value){
            match($name) {
                "idPartie" => $this->idPartie=$value,
                "datePartie" => $this->datePartie=$value,
                "jeu" => $this->jeu=$value,
                "joueur" => $this->joueur=$value,
                "score" => $this->score=$value,
                "historique" => $this->historique=$value,
                "gagnant" => $this->gagnant=$value
            };
        }

        // Compare le score de chaque joueur et garde le plus grand
        /*
        public function definirGagnant() {
            $plusGrandScore = 0;
            $joueurGagnant = null;
            for($i=0; $i<count($this->joueurs); $i++) {
                if($this->scores[$i]["Score"] > $plusGrandScore) {
                    $plusGrandScore = $this->scores[$i]["Score"];
                    $joueurGagnant = $this->joueurs[$i]->login;
                } elseif($this->scores[$i]["Score"] != 0 && $this->scores[$i]["Score"] == $plusGrandScore) {
                    $joueurGagnant = $joueurGagnant." et ".$this->joueurs[$i]->login." sont gagnants ";
                }
            }
            if($joueurGagnant == null) {
                $joueurGagnant = "Égalité";
            }
            $this->gagnant = [$joueurGagnant, $plusGrandScore];
        }
        */

        public function __toString() {
            $date = $this->datePartie->format('d-m-Y à H:i');
            $aff = "<br>Partie du ".$date."<br>";
            $aff = $aff.$this->jeu."<br><br>";
            $aff = $aff.$this->joueur->login.": ".$this->score."<br>";
            $aff = $aff.$this->affHistorique($this->historique);
            return $aff;
        } 

        private function affHistorique($histo) {
            $aff = "";
            for($i=0; $i<count($histo); $i++) {
                $aff = $aff.$i+1 ."° Lancer: ";
                for($y=0; $y<count($histo[$i]); $y++) {
                    $aff = $aff.$histo[$i][$y].", ";
                }
                $aff = $aff."<br>";
            }
            return $aff."<br>";
        }
    } 
?>