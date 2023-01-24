<?php
    class Partie {
        public function __construct(
            private DateTime $datePartie,
            private int $score = 0,
            private array $joueurs = []
        ) {}

        public function __get($name) {
            return match($name) {
                "datePartie" => $this->datePartie,
                "score" => $this->score,
                "joueurs" => $this->joueurs
            };
        }

        public function __set($name, $value){
            match($name) {
                "datePartie" => $this->datePartie=$value,
                "score" => $this->score=$value,
                "joueurs" => $this->joueurs=$value
            };
        }

        public function __toString() {
            $date = $this->datePartie->format('d-m-Y à H:i');
            $aff = "Partie du ".$date."<br>";
            $aff = $aff."Score: ".$this->score."<br>";
            return $aff;
        }
    }
?>