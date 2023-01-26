<?php
    namespace src\app\models;

    class Partie {
        public function __construct(
            private \DateTime $datePartie,
            private array $scores = [],
            private Jeu $jeu,
            private array $joueurs = [],
            private array $gagnant = []
        ) {}

        public function __get($name) {
            return match($name) {
                "datePartie" => $this->datePartie,
                "scores" => $this->scores,
                "jeu" => $this->jeu,
                "joueurs" => $this->joueurs,
                "gagnant" => $this->gagnant
            };
        }

        public function __set($name, $value){
            match($name) {
                "datePartie" => $this->datePartie=$value,
                "scores" => $this->scores[]=$value,
                "jeu" => $this->jeu=$value,
                "joueurs" => $this->joueurs=$value,
                "gagnant" => $this->gagnant=$value
            };
        }

        // Compare le score de chaque joueur et garde le plus grand
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

        public function __toString() {
            $date = $this->datePartie->format('d-m-Y à H:i');
            $aff = "<br>Partie du ".$date."<br>";
            $aff = $aff.$this->jeu."<br><br>";
            for($i=0; $i<count($this->joueurs); $i++) {
                $aff = $aff.$this->joueurs[$i]->login.": ".$this->scores[$i]["Score"]."<br>";
                $aff = $aff.$this->affHistorique($this->scores[$i]["Historique"]);
            }
            $aff = $aff."Gagnant: ".$this->gagnant[0]." avec ".$this->gagnant[1]." de score";
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