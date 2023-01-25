<?php
    namespace src\app\models;

    class Partie {
        public function __construct(
            private \DateTime $datePartie,
            private array $donnéesPartie = [],
            private Jeu $jeu,
            private array $joueurs = [],
            private array $gagnant = []
        ) {}

        public function __get($name) {
            return match($name) {
                "datePartie" => $this->datePartie,
                "donnéesPartie" => $this->donnéesPartie,
                "jeu" => $this->jeu,
                "joueurs" => $this->joueurs,
                "gagnant" => $this->gagnant
            };
        }

        public function __set($name, $value){
            match($name) {
                "datePartie" => $this->datePartie=$value,
                "donnéesPartie" => $this->donnéesPartie[]=$value,
                "jeu" => $this->jeu=$value,
                "joueurs" => $this->joueurs=$value,
                "gagnant" => $this->gagnant=$value
            };
        }

        public function definirGagnant() {
            $plusGrandScore = 0;
            $joueurGagnant = null;
            for($i=0; $i<count($this->joueurs); $i++) {
                if($this->donnéesPartie[$i]["Score"] > $plusGrandScore) {
                    $plusGrandScore = $this->donnéesPartie[$i]["Score"];
                    $joueurGagnant = $this->joueurs[$i];
                }
            }
            $this->gagnant = [$joueurGagnant, $plusGrandScore];
        }

        public function __toString() {
            $date = $this->datePartie->format('d-m-Y à H:i');
            $aff = "<br>Partie du ".$date."<br>";
            $aff = $aff.$this->jeu."<br><br>";
            for($i=0; $i<count($this->joueurs); $i++) {
                if($this->donnéesPartie[$i]["JetGagnant"]) {
                    $aff = $aff.$this->affJetGagnant($this->donnéesPartie[$i]["JetGagnant"]);
                }
                $aff = $aff.$this->joueurs[$i]->login.": ".$this->donnéesPartie[$i]["Score"]."<br><br>";
                $aff = $aff.$this->affHistorique($this->donnéesPartie[$i]["Historique"]);
            }
            $aff = $aff."Gagnant: ".$this->gagnant[0]->login." avec ".$this->gagnant[1]." de score";
            return $aff;
        }

        // Return un string contenant l'historique de tout les lancers
        private function affHistorique($histo) {
            $aff = "";
            for($i=0; $i<count($histo); $i++) {
                $aff = $aff."Lancer ".$i+1 .": <br>";
                for($y=0; $y<count($histo[$i]); $y++) {
                    $aff = $aff.$histo[$i][$y].", ";
                }
                $aff = $aff."<br>";
            }
            return $aff."<br>";
        }

        // Return un string contenant le jet gagnant
        private function affJetGagnant($jet) {
            $aff = "Jet gagnant: ";
            for($i=0; $i<count($jet); $i++) {
                $aff = $aff.$jet[$i].", ";
            }
            return $aff."<br>";
        }
    }
?>