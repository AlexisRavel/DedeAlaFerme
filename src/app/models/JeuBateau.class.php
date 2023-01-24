<?php
    include("JeuDeDes.class.php");

    class JeuBateau extends JeuDeDes {
        public function __construct(
            private string $regles = "",
            private array $parties = [],
            private int $nbDes = 5,
            private int $nbLancer = 3,
            private array $tableDe = [],
            private bool $aUnCapitaine = FALSE,
            private bool $aUnEquipage = FALSE,
            private bool $aUnBateau = FALSE,
            private bool $equipageComplet = FALSE
        ) {
            $regles = "Lancer les dés";
            parent::__construct($regles, $parties, $nbDes, $nbLancer, $tableDe);
        }

        public function __get($name) {
            return match($name) {
                "regles" => $this->regles,
                "parties" => $this->parties,
                "nbDes" => $this->nbDes,
                "nbLancer" => $this->nbLancer,
                "tableDe" => $this->tableDe,
                "aUnCapitaine" => $this->aUnCapitaine,
                "aUnEquipage" => $this->aUnEquipage,
                "aUnBateau" => $this->aUnBateau,
                "equipageComplet" => $this->equipageComplet
            };
        }

        public function __set($name, $value){
            match($name) {
                "regles" => $this->regles=$value,
                "parties" => $this->parties=$value,
                "nbDes" => $this->nbDes=$value,
                "nbLancer" => $this->nbLancer=$value,
                "tableDe" => $this->tableDe=$value,
                "aUnCapitaine" => $this->aUnCapitaine=$value,
                "aUnEquipage" => $this->aUnEquipage=$value,
                "aUnBateau" => $this->aUnBateau=$value,
                "equipageComplet" => $this->equipageComplet=$value
            };
        }
    }
?>