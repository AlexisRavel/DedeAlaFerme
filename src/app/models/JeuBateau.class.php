<?php
    namespace src\app\models;

    class JeuBateau extends JeuDeDes {
        const VAL_BATEAU = 6;
        const VAL_CAPITAINE = 5;
        const VAL_EQUIPAGE = 4;

        public function __construct(
            private string $regles = "Lancer les dés",
            private array $parties = [],
            private int $nbDes = 5,
            private int $nbLancer = 3,
            private array $tableDe = [],
            private array $historiqueJeu = [],
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
                "historiqueJeu" => $this->historiqueJeu,
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
                "historiqueJeu" => $this->historiqueJeu=$value,
                "aUnBateau" => $this->aUnBateau=$value,
                "aUnCapitaine" => $this->aUnCapitaine=$value,
                "aUnEquipage" => $this->aUnEquipage=$value,
                "equipageComplet" => $this->equipageComplet=$value
            };
        }

        /*
            Lance les dés puis set mapJeuBateau -> tableau associatif des données des lancers du joueur
            ["Historique"] => Tout les lancers effectuer jusqu'à la possiblité de calculer le score
            ["JetGagnant"] => Le dernier jet effectuer sans les dés compter pour la condition de victoire
            ["Score"] => Le score calculer à partir du jet gagnant
        */
        public function jouer() {
            $this->resetJeu();
            $lancers = parent::lancerDes();
            $this->historiqueJeu = $lancers;

            for($i=0; $i<count($lancers); $i++) {
                $this->verifLancer($lancers[$i]);
                if($this->equipageComplet) {
                    $mapJeuBateau = array();

                    // Enregistrement historique
                    // Ne prends que l'historique du nb de lancer suffisant
                    // (ex: si 6, 5 et 4 en deux lancer, ne prendra pas le troisième lancer)
                    $histo = array();
                    $cpt = $i;
                    while($cpt>=0) {
                        $histo[] = $this->historiqueJeu[$cpt];
                        $cpt--;
                    }
                    $histo = array_reverse($histo);
                    $mapJeuBateau["Historique"] = $histo;

                    // Jet gagnant = jet grâce auquel on rentre dans la boucle
                    // Et qui comprends seulement les des necessaires pour le score 
                    $mapJeuBateau["JetGagnant"] = $lancers[$i];
                    
                    // Calcul du score grâce au jet gagnant
                    $score = 0;
                    for($y=0; $y<count($lancers[$i]); $y++) {
                        $score += $lancers[$i][$y];
                    }
                    $mapJeuBateau["Score"] = $score;

                    return $mapJeuBateau;
                }
            }

            $mapJeuBateau = array();
            $mapJeuBateau["Historique"] = $this->historiqueJeu;
            $mapJeuBateau["JetGagnant"] = null;
            $mapJeuBateau["Score"] = 0;
            return $mapJeuBateau;
        }

        // Appel une fonction verif correspondante au boolean == TRUE:
        // Si dans les lancers précédants -> aUnBateau == TRUE:
        // Alors verif seulement le capitaine et l'équipage
        private function verifLancer(&$tabLancer) {
            if($this->aUnBateau && $this->aUnCapitaine) {
                $this->verifSiEquipage($tabLancer);
            } elseif($this->aUnBateau) {
                $this->verifSiCapitaineEquipage($tabLancer);
            } else {
                $this->verifSiRien($tabLancer);
            }
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
                if(in_array(self::VAL_CAPITAINE, $tabLancer)) {
                    $this->aUnCapitaine = TRUE;
                    unset($tabLancer[array_search(self::VAL_CAPITAINE, $tabLancer)]);
                    $tabLancer = array_values($tabLancer);
                    if(in_array(self::VAL_EQUIPAGE, $tabLancer)) {
                        $this->aUnEquipage = TRUE;
                        unset($tabLancer[array_search(self::VAL_EQUIPAGE, $tabLancer)]);
                        $tabLancer = array_values($tabLancer);
                        $this->equipageComplet = TRUE;
                    }
                }
            }
        }

        private function verifSiCapitaineEquipage(&$tabLancer) {
            if(in_array(self::VAL_CAPITAINE, $tabLancer)) {
                $this->aUnCapitaine = TRUE;
                unset($tabLancer[array_search(self::VAL_CAPITAINE, $tabLancer)]);
                $tabLancer = array_values($tabLancer);
                if(in_array(self::VAL_EQUIPAGE, $tabLancer)) {
                    $this->aUnEquipage = TRUE;
                    unset($tabLancer[array_search(self::VAL_EQUIPAGE, $tabLancer)]);
                    $tabLancer = array_values($tabLancer);
                    $this->equipageComplet = TRUE;
                }
            }
        }

        private function verifSiEquipage(&$tabLancer) {
            if(in_array(self::VAL_EQUIPAGE, $tabLancer)) {
                $this->aUnEquipage = TRUE;
                unset($tabLancer[array_search(self::VAL_EQUIPAGE, $tabLancer)]);
                $tabLancer = array_values($tabLancer);
                $this->equipageComplet = TRUE;
            }
        }

        // Reset les booleans et les tableaux pour les prochains lancers
        private function resetJeu() {
            $this->tableDe = array();
            $this->historiqueJeu = array();
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