<?php
    include("Jeu.class.php");

    abstract class JeuDeDes extends Jeu {
        public function __construct(
            private string $regles,
            private array $parties,
            private int $nbDes,
            private int $nbLancer,
            private array $tableDe
        ) {
            parent::__construct($regles, $parties);
        }

        // Lance les des, retourne rien
        public function lancerDes() {
            return 1;
        }
    }
?>