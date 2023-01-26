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
            array $historiqueDe,
            private bool $aUnBateau = FALSE,
            private bool $aUnCapitaine = FALSE,
            private bool $aUnEquipage = FALSE,
            private bool $equipageComplet = FALSE
        ) {
            parent::__construct($regles, $parties, $nbDes, $nbLancer, $tableDe, $historiqueDe);
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

       
        public function traitementLancer() {
            // Vérifie le lancer en fonction des jets précédents
            if($this->aUnBateau && $this->aUnCapitaine) {
                $this->verifSiEquipage();
            } elseif($this->aUnBateau) {
                $this->verifSiCapitaineEquipage();
            } else {
                $this->verifSiRien();
            }

            // Si équipageComplet == conditions victoires vérifiées -> calcul du score
            $dernierLancer = $this->tableDe[count($this->tableDe)-1];
            if($this->equipageComplet) {
                $score = 0;
                for($i=0; $i<count($dernierLancer); $i++) {
                    $score += $dernierLancer[$i];
                }
                end($this->parties)->scores = ["Score"=>$score, "Historique"=>$this->historiqueDe];
                return 1;
            }
            if(count($this->tableDe) == $this->nbLancer) {
                end($this->parties)->scores = ["Score"=>0, "Historique"=>$this->historiqueDe];
                return 1;
            }

            return 0;
        }

        /*
            Pour chaque étape des trois fonctions verif:
            1- On vérifie si le dernier lancer contient VAL_BATEAU CAPITAINE ou EQUIPAGE, Si c'est le cas:
            2- On set le boolean correspondant à TRUE et on enleve un dé
            Si on arrive au bout de toutes les conditions -> on enleve dans le dernier lancer tous les dés que l'on vient de trouver,
            on set equipageComplet à TRUE et on remplace dans tableDe le nouveau tableau sans les dés necessaires à la victoire pour le calcul du score
        */
        private function verifSiRien() {
            $dernierLancer = $this->tableDe[count($this->tableDe)-1];
            if(in_array(self::VAL_BATEAU, $dernierLancer)) {
                $this->aUnBateau = TRUE;
                $this->nbDes--;
                if(in_array(self::VAL_CAPITAINE, $dernierLancer)) {
                    $this->aUnCapitaine = TRUE;
                    $this->nbDes--;
                    if(in_array(self::VAL_EQUIPAGE, $dernierLancer)) {
                        $this->aUnEquipage = TRUE;
                        $this->nbDes--;
                        $this->equipageComplet = TRUE;
                        unset($dernierLancer[array_search(self::VAL_BATEAU, $dernierLancer)]);
                        unset($dernierLancer[array_search(self::VAL_CAPITAINE, $dernierLancer)]);
                        unset($dernierLancer[array_search(self::VAL_EQUIPAGE, $dernierLancer)]);
                        $this->tableDe[count($this->tableDe)-1] = array_values($dernierLancer);
                    }
                }
            }
        }

        private function verifSiCapitaineEquipage() {
            $dernierLancer = $this->tableDe[count($this->tableDe)-1];
            if(in_array(self::VAL_CAPITAINE, $dernierLancer)) {
                $this->aUnCapitaine = TRUE;
                $this->nbDes--;
                if(in_array(self::VAL_EQUIPAGE, $dernierLancer)) {
                    $this->aUnEquipage = TRUE;
                    $this->nbDes--;
                    $this->equipageComplet = TRUE;
                    unset($dernierLancer[array_search(self::VAL_CAPITAINE, $dernierLancer)]);
                    unset($dernierLancer[array_search(self::VAL_EQUIPAGE, $dernierLancer)]);
                    $this->tableDe[count($this->tableDe)-1] = array_values($dernierLancer);
                }
            }
        }

        private function verifSiEquipage() {
            $dernierLancer = $this->tableDe[count($this->tableDe)-1];
            if(in_array(self::VAL_EQUIPAGE, $dernierLancer)) {
                $this->aUnEquipage = TRUE;
                $this->nbDes--;
                $this->equipageComplet = TRUE;
                unset($dernierLancer[array_search(self::VAL_EQUIPAGE, $dernierLancer)]);
                $this->tableDe[count($this->tableDe)-1] = array_values($dernierLancer);
            }
        }

        // Reset les booleans et les tableaux pour les prochains lancers
        public function resetJeu() {
            $this->nbDes = 5;
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