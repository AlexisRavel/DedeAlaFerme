<?php
    namespace src\app\models;

    abstract class JeuDeDes extends Jeu {
        public function __construct(
            string $regles,
            array $parties,
            protected int $nbDes,
            protected int $nbLancer,
            protected array $tableDe,
            protected array $historiqueDe
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

        // Lance les des, vérifie les lancers, si score calculer dans traitementLancer -> finTraitement = TRUE
        public function lancerDes() {
            $this->resetJeu();
            // Init des tables de lancers
            $this->tableDe = array();
            $this->historiqueDe = array();
            $finTraitement = FALSE;

            // Lance les dés puis vérifie chaque lancer
            for($i=0; $i<$this->nbLancer; $i++) {
                $tabLancer = [];
                for($y=0; $y<$this->nbDes; $y++) {
                    $tabLancer[] = random_int(1, 6);
                }
                $this->tableDe[] = $tabLancer;
                $this->historiqueDe[] = $tabLancer;
                $finTraitement = $this->traitementLancer();

                // Terminer les lancers si score calculer
                if($finTraitement) {
                    return 1;
                }
            }
        }

        // Reset les booleans et les tableaux pour les prochains lancers
        abstract function resetJeu();

        abstract function traitementLancer();
    }
?>