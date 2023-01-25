<?php
    namespace src\app\models;

    class JeuBateau extends JeuDeDes {
        const VAL_BATEAU = 6;
        const VAL_CAPITAINE = 5;
        const VAL_EQUIPAGE = 4;

        public function __construct(
            string $regles,
            array $parties,
            int $nbDes,
            int $nbLancer,
            array $tableDe,
            private bool $aUnBateau = FALSE,
            private bool $aUnCapitaine = FALSE,
            private bool $aUnEquipage = FALSE,
            private bool $equipageComplet = FALSE
        ) {
            parent::__construct($regles, $parties, $nbDes, $nbLancer, $tableDe);
        }

        public function __get($name) {
            return match($name) {
                "regles" => $this->regles,
                "parties" => $this->parties,
                "nbDes" => $this->nbDes,
                "nbLancer" => $this->nbLancer,
                "tableDe" => $this->tableDe,
                "aUnBateau" => $this->aUnBateau,
                "aUnCapitaine" => $this->aUnCapitaine,
                "aUnEquipage" => $this->aUnEquipage,
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
                "aUnBateau" => $this->aUnBateau=$value,
                "aUnCapitaine" => $this->aUnCapitaine=$value,
                "aUnEquipage" => $this->aUnEquipage=$value,
                "equipageComplet" => $this->equipageComplet=$value
            };
        }

       
        public function traitementLancer($tabLancer, $numLancer, $table) {
            if($this->aUnBateau && $this->aUnCapitaine) {
                $this->verifSiEquipage($tabLancer);
            } elseif($this->aUnBateau) {
                $this->verifSiCapitaineEquipage($tabLancer);
            } else {
                $this->verifSiRien($tabLancer);
            }

            if($this->equipageComplet) {
                $score = 0;
                for($i=0; $i<count($tabLancer); $i++) {
                    $score += $tabLancer[$i];
                }
                end($this->parties)->scores = ["Score"=>$score, "Historique"=>$table];
                return 1;
            }
            if($numLancer+1 == $this->nbLancer) {
                end($this->parties)->scores = ["Score"=>0, "Historique"=>$table];
                return 1;
            }

            return 0;
        }

        /*
            POUR LES 3 FONCTIONS verif:
                
            1- Verif si le dé rechercher est dans le lancer
            Si TRUE:
            2- Set la variable correspondante à TRUE
            3- Retirer le de pour le calcul du score
            4- Réindexer le tableau (voir unset())
            Et si les trois booleans aUnBateau, aUnCapitaine et aUnEquipage == TRUE:
            Set equipageComplet == TRUE
        */
        private function verifSiRien(&$tabLancer) {
            if(in_array(self::VAL_BATEAU, $tabLancer)) {
                $this->aUnBateau = TRUE;
                unset($tabLancer[array_search(self::VAL_BATEAU, $tabLancer)]);
                $tabLancer = array_values($tabLancer);
                $this->nbDes -= 1;
                if(in_array(self::VAL_CAPITAINE, $tabLancer)) {
                    $this->aUnCapitaine = TRUE;
                    unset($tabLancer[array_search(self::VAL_CAPITAINE, $tabLancer)]);
                    $tabLancer = array_values($tabLancer);
                    $this->nbDes -= 1;
                    if(in_array(self::VAL_EQUIPAGE, $tabLancer)) {
                        $this->aUnEquipage = TRUE;
                        unset($tabLancer[array_search(self::VAL_EQUIPAGE, $tabLancer)]);
                        $tabLancer = array_values($tabLancer);
                        $this->equipageComplet = TRUE;
                        $this->nbDes -= 1;
                    }
                }
            }
        }

        private function verifSiCapitaineEquipage(&$tabLancer) {
            if(in_array(self::VAL_CAPITAINE, $tabLancer)) {
                $this->aUnCapitaine = TRUE;
                unset($tabLancer[array_search(self::VAL_CAPITAINE, $tabLancer)]);
                $tabLancer = array_values($tabLancer);
                $this->nbDes -= 1;
                if(in_array(self::VAL_EQUIPAGE, $tabLancer)) {
                    $this->aUnEquipage = TRUE;
                    unset($tabLancer[array_search(self::VAL_EQUIPAGE, $tabLancer)]);
                    $tabLancer = array_values($tabLancer);
                    $this->equipageComplet = TRUE;
                    $this->nbDes -= 1;
                }
            }
        }

        private function verifSiEquipage(&$tabLancer) {
            if(in_array(self::VAL_EQUIPAGE, $tabLancer)) {
                $this->aUnEquipage = TRUE;
                unset($tabLancer[array_search(self::VAL_EQUIPAGE, $tabLancer)]);
                $tabLancer = array_values($tabLancer);
                $this->equipageComplet = TRUE;
                $this->nbDes -= 1;
            }
        }

        // Reset les booleans et les tableaux pour les prochains lancers
        public function resetJeu() {
            parent::__set("nbDes", 5);
            $this->tableDe = array();
            $this->aUnBateau = FALSE;
            $this->aUnCapitaine = FALSE;
            $this->aUnEquipage = FALSE;
            $this->equipageComplet = FALSE;
        }

        public function __toString() {
            $aff = "Jeu du Bateau: <br>Regles: ".$this->regles;
            $aff = $aff."";
            return $aff;
        }
    }
?>