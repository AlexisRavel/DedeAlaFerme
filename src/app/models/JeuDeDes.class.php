<?php
    abstract class JeuDeDes extends Jeu {
        public function __construct(
            private string $regles,
            private int $nbDes,
            private int $nbLancer,
            private array $tableDe
        ) {
            parent::__construct($regles);
        }

        // Lance les des, retourne rien
        public function lancerDes() {
            return 1;
        }
    }
?>