<?php
    include("JeuDeDes.class.php");

    class JeuBateau extends JeuDeDes {
        public function __construct(
            private string $regles = "Lancer les dés",
            private array $parties = [],
            private int $nbDes = 5,
            private int $nbLancer = 3,
            private array $tableDe = [],
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

        public function jouer() {
            $this->resetJeu();
            $lancers = parent::lancerDes();
            for($i=0; $i<count($lancers); $i++) {
                $this->verifLancer($i, $lancers[$i]);
                if($this->equipageComplet) {
                    // Calcul du score
                    $score = 0;
                    for($y=0; $y<count($lancers[$i]); $y++) {
                        $score += $lancers[$i][$y];
                    }

                    echo "<pre>";
                    var_dump($lancers[$i]);
                    echo "</pre>";
                    echo $score;

                    return $score;
                }
            }
            return 0;
        }

        private function verifLancer(&$numbLancer, &$tabLancer) {
            switch($numbLancer) {
                case 0:
                    $this->verifSiRien($tabLancer);
                    break;
                case 1|2:
                    if($this->aUnBateau && $this->aUnCapitaine) {
                        $this->verifSiBateauCapitaine($tabLancer);
                    } elseif($this->aUnBateau) {
                        $this->verifSiBateau($tabLancer);
                    } else {
                        $this->verifSiRien($tabLancer);
                    }
                    break;
            }
        }

        private function verifSiRien(&$tabLancer) {
            if(in_array(6, $tabLancer)) {
                $this->aUnBateau = TRUE;
                unset($tabLancer[array_search([6], $tabLancer)]);
                $tabLancer = array_values($tabLancer);
                echo "<p>Bateau 1</p>";
                if(in_array(5, $tabLancer)) {
                    $this->aUnCapitaine = TRUE;
                    unset($tabLancer[array_search([5], $tabLancer)]);
                    $tabLancer = array_values($tabLancer);
                    echo "<p>Capitaine 1</p>";
                    if(in_array(4, $tabLancer)) {
                        $this->aUnEquipage = TRUE;
                        unset($tabLancer[array_search([4], $tabLancer)]);
                        $tabLancer = array_values($tabLancer);
                        echo "<p>Equipage 1</p>";
                        $this->equipageComplet = TRUE;
                    }
                }
            }
        }

        private function verifSiBateau(&$tabLancer) {
            if(in_array(5, $tabLancer)) {
                $this->aUnCapitaine = TRUE;
                unset($tabLancer[array_search([5], $tabLancer)]);
                $tabLancer = array_values($tabLancer);
                echo "<p>Capitaine 2</p>";
                if(in_array(4, $tabLancer)) {
                    $this->aUnEquipage = TRUE;
                    unset($tabLancer[array_search([4], $tabLancer)]);
                    $tabLancer = array_values($tabLancer);
                    echo "<p>Equipage 2</p>";
                    $this->equipageComplet = TRUE;
                }
            }
        }

        private function verifSiBateauCapitaine(&$tabLancer) {
            if(in_array(4, $tabLancer)) {
                $this->aUnEquipage = TRUE;
                unset($tabLancer[array_search([4], $tabLancer)]);
                $tabLancer = array_values($tabLancer);
                echo "<p>Equipage 2</p>";
                $this->equipageComplet = TRUE;
            }
        }

        // Reset les booleans pour les prochains lancers
        private function resetJeu() {
            $this->aUnBateau = FALSE;
            $this->aUnCapitaine = FALSE;
            $this->aUnEquipage = FALSE;
            $this->equipageComplet = FALSE;
        }

        public function __toString() {
            return "Jeu du Bateau: <br>Regles: ".$this->regles;
        }
    }
?>