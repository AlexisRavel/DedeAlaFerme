<?php
    class User {
        public function __construct(
            private int $idUser,
            protected string $login,
            private string $mdp,
            private string $droits
        ) {}

        public function connecter() {
            return 1;
        }

        public function deconnecter() {
            return 1;
        }

        public function inscription() {
            return 1;
        }
    }
?>