<?php
    class Partie {
        public function __construct(
            private DateTime $datePartie,
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
            $aff = $aff.$this->jeu."<br>";
            for($i=0; $i<count($this->joueurs); $i++) {
                $aff = $aff.$this->joueurs[$i]->login.": ".$this->score[$i]."<br>";
            }
            return $aff;
        }
    }
?>