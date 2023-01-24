<?php
    include("JeuDeDes.class.php");

    class JeuBateau extends JeuDeDes {
        public function __construct(
            private string $regles = "Lancer les dés",
            private array $parties = [],
            private int $nbDes = 5,
            private int $nbLancer = 3,
            private array $tableDe = [],
            private array $historiqueDe = [],
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
                "historiqueDe" => $this->historiqueDe,
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
                "historiqueDe" => $this->historiqueDe=$value,
                "aUnCapitaine" => $this->aUnCapitaine=$value,
                "aUnEquipage" => $this->aUnEquipage=$value,
                "aUnBateau" => $this->aUnBateau=$value,
                "equipageComplet" => $this->equipageComplet=$value
            };
        }

        public function jouer() {
            $this->resetJeu();
            $lancers = parent::lancerDes();
            $this->historiqueDe = $lancers;
            for($i=0; $i<count($lancers); $i++) {
                $this->verifLancer($i, $lancers[$i]);
                if($this->equipageComplet) {
                    $mapJeuBateau = array();

                    // Enregistrement historique
                    $histo = array();
                    $cpt = $i;
                    while($cpt>=0) {
                        $histo[] = $this->historiqueDe[$cpt];
                        $cpt--;
                    }
                    $histo = array_reverse($histo);
                    $mapJeuBateau["Historique"] = $histo;
                    $mapJeuBateau["JetGagnant"] = $lancers[$i];
                    
                    // Calcul du score
                    $score = 0;
                    for($y=0; $y<count($lancers[$i]); $y++) {
                        $score += $lancers[$i][$y];
                    }
                    $mapJeuBateau["Score"] = $score;

                    echo "<pre>";
                    var_dump($mapJeuBateau);
                    echo "</pre>";

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
                case 1:
                    if($this->aUnBateau && $this->aUnCapitaine) {
                        $this->verifSiBateauCapitaine($tabLancer);
                    } elseif($this->aUnBateau) {
                        $this->verifSiBateau($tabLancer);
                    } else {
                        $this->verifSiRien($tabLancer);
                    }
                    break;
                case 2:
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
                unset($tabLancer[array_search(6, $tabLancer)]);
                $tabLancer = array_values($tabLancer);
                if(in_array(5, $tabLancer)) {
                    $this->aUnCapitaine = TRUE;
                    unset($tabLancer[array_search(5, $tabLancer)]);
                    $tabLancer = array_values($tabLancer);
                    if(in_array(4, $tabLancer)) {
                        $this->aUnEquipage = TRUE;
                        unset($tabLancer[array_search(4, $tabLancer)]);
                        $tabLancer = array_values($tabLancer);
                        $this->equipageComplet = TRUE;
                    }
                }
            }
        }

        private function verifSiBateau(&$tabLancer) {
            if(in_array(5, $tabLancer)) {
                $this->aUnCapitaine = TRUE;
                unset($tabLancer[array_search(5, $tabLancer)]);
                $tabLancer = array_values($tabLancer);
                if(in_array(4, $tabLancer)) {
                    $this->aUnEquipage = TRUE;
                    unset($tabLancer[array_search(4, $tabLancer)]);
                    $tabLancer = array_values($tabLancer);
                    $this->equipageComplet = TRUE;
                }
            }
        }

        private function verifSiBateauCapitaine(&$tabLancer) {
            if(in_array(4, $tabLancer)) {
                $this->aUnEquipage = TRUE;
                unset($tabLancer[array_search(4, $tabLancer)]);
                $tabLancer = array_values($tabLancer);
                $this->equipageComplet = TRUE;
            }
        }

        // Reset les booleans pour les prochains lancers
        private function resetJeu() {
            $this->tableDe = array();
            $this->historiqueDe = array();
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