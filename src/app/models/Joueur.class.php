<?php
    include("User.class.php");
    include("Partie.class.php");

    class Joueur extends User {
        public function __construct(
            private int $idUser,
            protected string $login,
            private string $mdp,
            private string $droits,
            private array $parties = []
        ) {
            parent::__construct($idUser, $login, $mdp, $droits);
        }

        public function __get($name) {
            return match($name) {
                "idUser" => $this->idUser,
                "login" => $this->login,
                "mdp" => $this->mdp,
                "droits" => $this->droits,
                "parties" => $this->parties
            };
        }

        public function __set($name, $value){
            match($name) {
                "idUser" => $this->idUser=$value,
                "login" => $this->login=$value,
                "mdp" => $this->mdp=$value,
                "droits" => $this->droits=$value,
                "parties" => $this->parties=$value
            };
        }

        public function lancerPartie() {
            $date = new DateTime('now', new DateTimeZone("Europe/Paris"));
            $partie = new Partie($date);
            $this->parties[] = $partie;
        }

        public function __toString() {
            $aff = parent::__toString();
            for($i=0; $i<count($this->parties); $i++) {
                $aff = $aff."<br>";
                $aff = $aff.$this->parties[$i];
            }
            return $aff;
        }
    }
?>