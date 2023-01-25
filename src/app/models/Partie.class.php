<?php
    namespace src\app\models;

    class Partie {
        public function __construct(
            private \DateTime $datePartie,
            private array $score = [],
            private Jeu $jeu,
            private array $joueurs = []
        ) {}

        public function __get($name) {
            return match($name) {
                "datePartie" => $this->datePartie,
                "score" => $this->score,
                "jeu" => $this->jeu,
                "joueurs" => $this->joueurs
            };
        }

        public function __set($name, $value){
            match($name) {
                "datePartie" => $this->datePartie=$value,
                "score" => $this->score[]=$value,
                "jeu" => $this->jeu=$value,
                "joueurs" => $this->joueurs=$value
            };
        }

        public function __toString() {
            $date = $this->datePartie->format('d-m-Y à H:i');
            $aff = "<br>Partie du ".$date."<br>";
            $aff = $aff.$this->jeu."<br><br>";
            for($i=0; $i<count($this->joueurs); $i++) {
                if($this->score[$i]["JetGagnant"]) {
                    $aff = $aff.$this->affJetGagnant($this->score[$i]["JetGagnant"]);
                }
                $aff = $aff.$this->joueurs[$i]->login.": ".$this->score[$i]["Score"]."<br><br>";
                $aff = $aff.$this->affHistorique($this->score[$i]["Historique"]);
            }
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