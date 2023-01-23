<?php
    include("JeuDeDes.class.php");

    class JeuBateau extends JeuDeDes {
        public function __construct(
            private string $regles,
            private array $parties,
            private int $nbDes,
            private int $nbLancer,
            private array $tableDe,
            private bool $aUnCapitaine,
            private bool $aUnEquipage,
            private bool $aUnBateau,
            private bool $equipageComplet
        ) {
            parent::__construct($regles, $parties, $nbDes, $nbLancer, $tableDe);
        }
    }
?>