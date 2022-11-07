<?php
namespace netvod\Auth;

use NetVOD\db\ConnectionFactory;
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
            session_start();
            $tab = [
                "email" => $email,
                "mdp" => $mdp,
                "id" => $data['id'],
                "role" => $data['role'],
            ];
            $_SESSION["connexion"] = $tab;
            return new \iutnc\deefy\db\User($email, $data['passwd'], $data['role']);
        } else {
            return null;
        }
    }

    static function register($mail, $mdp)
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
            $role = 1;

            $stmt = $connexion->prepare('INSERT INTO user VALUES(?, ?, ?, ?)');
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $mail);
            $stmt->bindParam(3, $passhash);
            $stmt->bindParam(4, $role);
            $stmt->execute();
            return "succès";
        }

    }

//    public static function verifAdminPlaylist($id_pl):bool
//    {
//        session_start();
//        if (!empty($_SESSION['connexion'])) {
//            $log = $_SESSION['connexion'];
//            if ($log['role'] == 100) {
//                return true;
//            } else {
//                $connexion = ConnectionFactory::makeConnection();
//                $stmt = $connexion->prepare('SELECT * FROM user2playlist WHERE id_pl = ?');
//                $stmt->bindParam(1, $id_pl);
//                $stmt->execute();
//                $data = $stmt->fetch(PDO::FETCH_ASSOC);
//                $stmtverif = $connexion->prepare('SELECT * FROM playlist WHERE id = ?');
//                $stmtverif->bindParam(1, $id_pl);
//                $stmtverif->execute();
//                $rowcount = $stmtverif->rowCount();
//                if ($rowcount == 0){
//                    return false;
//                }
//                if ($log['role'] == $data['id_user']) {
//                    return true;
//                } else {
//                    return false;
//                }
//            }
//        } else {
//            return false;
//        }
//    }

}