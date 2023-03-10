<?php
    namespace src\app\models;

    abstract class User {
        public function __construct(
            private int $idUser,
            protected string $login,
            private string $mdp,
            private string $droits
        ) {}

        public function __get($name) {
            return match($name) {
                "idUser" => $this->idUser,
                "login" => $this->login,
                "mdp" => $this->mdp,
                "joueurs" => $this->joueurs
            };
        }

        public function __set($name, $value){
            match($name) {
                "idUser" => $this->idUser=$value,
                "login" => $this->login=$value,
                "mdp" => $this->mdp=$value,
                "droits" => $this->droits=$value
            };
        }

        public function connecter() {
            return 1;
        }

        public function deconnecter() {
            return 1;
        }

        public function inscription() {
            return 1;
        }

        public function __toString() {
            return "Id: ".$this->idUser." | Login: ".$this->login." | Mdp: ".$this->mdp." | Droits: ".$this->droits;
        }
    }
?>