<?php
    namespace src\app\models;

    abstract class JeuDeDes extends Jeu {
        public function __construct(
            private string $regles,
            private array $parties = [],
            private int $nbDes,
            private int $nbLancer,
            private array $tableDe
        ) {
            parent::__construct($regles, $parties);
        }

        public function __get($name) {
            return match($name) {
                "regles" => $this->regles,
                "parties" => $this->parties,
                "nbDes" => $this->nbDes,
                "nbLancer" => $this->nbLancer,
                "tableDe" => $this->tableDe
            };
        }

        public function __set($name, $value){
            match($name) {
                "regles" => $this->regles=$value,
                "parties" => $this->parties=$value,
                "nbDes" => $this->nbDes=$value,
                "nbLancer" => $this->nbLancer=$value,
                "tableDe" => $this->tableDe=$value
            };
        }

        // Lance les des, retourne tableDe -> la liste de tout les lancers
        public function lancerDes() {
            $this->tableDe = [];
            for($i=0; $i<$this->nbLancer; $i++) {
                $tabLancer = [];
                for($y=0; $y<$this->nbDes; $y++) {
                    $tabLancer[] = random_int(1, 6);
                }
                $this->tableDe[] = $tabLancer;
            }
            return $this->tableDe;
        }
    }
?>