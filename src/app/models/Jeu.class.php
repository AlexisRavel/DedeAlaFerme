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

        // Aff le classement des gagnants de toutes les parties ->  position : login : score
        public function affClassement() {
            // Récupération de tous les gagnants
            $tabGagnants = array();
            for($i=0; $i<count($this->parties); $i++) {
                if(strlen($this->parties[$i]->gagnant[0]) == 7) {
                    $tabGagnants[] = $this->parties[$i]->gagnant;
                }
            }

            // Suppression des scores moins haut et doublons d'un même joueur
            for($i=0; $i<count($tabGagnants); $i++) {
                for($y=0; $y<count($tabGagnants); $y++) {
                    // Retire de tabGagnants les scores moins haut d'un même joueur
                    if($tabGagnants[$i] != $tabGagnants[$y] && $tabGagnants[$i][0] == $tabGagnants[$y][0]) {
                        $tabGagnants[$i][1] < $tabGagnants[$y][1] ? $moinsHautScore = $tabGagnants[$i] : $moinsHautScore = $tabGagnants[$y];
                        unset($tabGagnants[array_search($moinsHautScore, $tabGagnants)]);
                        $tabGagnants = array_values($tabGagnants);
                        $i = 0;
                        $y = 0;
                    }
                    // Retire de tabGagnants les mêmes scores d'un même joueur
                    if($i != $y && $tabGagnants[$i][0] == $tabGagnants[$y][0] && $tabGagnants[$i][1] == $tabGagnants[$y][1]) {
                        unset($tabGagnants[$y]);
                        $tabGagnants = array_values($tabGagnants);
                    }
                }
            }

            // Tri
            usort($tabGagnants, [self::class, "cmp"]);
            
            // Aff du tableau tabGagnants
            echo "Nombre de parties: ".count($this->parties);
            echo "<table>";
            echo "<tr>";
            echo "<th>Position</th>";
            echo "<th>Joueur</th>";
            echo "<th>Score</th>";
            echo "<tr>";
            for($i=0; $i<count($tabGagnants); $i++) {
                echo "<tr>";
                echo "<td>".$i+1 ."</td>";
                echo "<td>".$tabGagnants[$i][0]."</td>";
                echo "<td>".$tabGagnants[$i][1]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }

        function cmp($a, $b) {
            return $a[1]>$b[1] ? null : $a;
        }

        public function __toString() {
            return "Regles: ".$this->regles;
        }
    }
?>