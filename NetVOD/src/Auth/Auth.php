<?php
namespace NetVOD\Auth;

use NetVOD\db\ConnectionFactory;
use NetVOD\User\User;
use PDO;

class Auth{

    static function authenticate($email, $mdp) : ?User
    {
        $dbh = ConnectionFactory::makeConnection();
        $stmt = $dbh->prepare('SELECT * FROM user WHERE email = ?');
        $stmt->bindParam(1, $email);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $datac = $stmt->rowCount();
        if (($datac) == 0){
            return null;
        }
        $boo = password_verify($mdp, $data['passwd']);

        if($boo){
            
            $tab = [
                "email" => $email,
                "mdp" => $mdp,
                "id" => $data['id'],
            ];
            $_SESSION["connexion"] = $tab;
            return new User($email, $data['passwd']);
        } else {
            return null;
        }
    }

    static function register($mail, $mdp) : string
    {

        //Longueur
        if (strlen($mdp) <10){
            return "Erreur : Mot de passe pas assez long (min : 10)";

        }

        //Email existant
        $connexion = ConnectionFactory::makeConnection();
        $stmt = $connexion->prepare('SELECT * FROM user WHERE email = ?');
        $stmt->bindParam(1, $mail);
        $stmt->execute();
        $rowcount = $stmt->rowCount();
        if ($rowcount > 0){
            return "Erreur : Email déjà utilisé";
        }

        //Hachage
        if (strlen($mdp) >= 10 && $rowcount == 0) {
            $passhash = password_hash($mdp, PASSWORD_BCRYPT);
            $stmt = $connexion->query('SELECT * FROM user ORDER BY ID DESC LIMIT 1');
            $stmt->execute();
            $data = $stmt ->fetch(PDO::FETCH_ASSOC);
            $id = $data['id']+1;

            $stmt = $connexion->prepare('INSERT INTO user VALUES(?, ?, ?)');
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $mail);
            $stmt->bindParam(3, $passhash);
            $stmt->execute();
            return "succès";
        }

    }

}