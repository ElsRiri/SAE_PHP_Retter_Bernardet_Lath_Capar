<?php
namespace NetVOD\Auth;

use Exception;
use NetVOD\action\ActivationTokenAction;
use NetVOD\action\InscriptionAction;
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
            
            //$tab = [
                //"email" => $email,
                //"mdp" => $mdp,
                //"id" => $data['id'],
            //];
            $_SESSION["connexion"] = new User($email, $data['passwd']);
            return new User($email, $data['passwd']);
        } else {
            return null;
        }
    }

    static function register($mail, $mdp) : string
    {
        echo $mdp;
        echo $mail;
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

            $stmt = $connexion->prepare('INSERT INTO user (id,email,passwd) VALUES(?, ?, ?)');
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $mail);
            $stmt->bindParam(3, $passhash);
            $stmt->execute();

            return Auth::enregistrerToken($mail);
        }

    }


    public static function enregistrerToken($mail):string{
        $token = bin2hex(random_bytes(32));
        $dateT = date('Y-m-d H:i:s',time() + 60*60);

        $sql = "UPDATE user SET activation_token='$token' , 
        activation_expires =  ADDTIME('$dateT','00:00:00') WHERE email='$mail'";
        $res = ConnectionFactory::$db->prepare($sql);
        $res->execute();


        return $token;

    }

    public static function enregistrerNewToken($mail):string{
        $token = bin2hex(random_bytes(32));
        $dateT = date('Y-m-d H:i:s',time() + 60*60);

        $sql = "UPDATE user SET renew_token='$token' , 
        renew_expires =  ADDTIME('$dateT','00:00:00') WHERE email='$mail'";
        $res = ConnectionFactory::$db->prepare($sql);
        $res->execute();

        return $token;

    }

    public static function activate(string $token): bool {
        $activation = false;
        $mail = "";
        $dateCourant = date('Y-m-d H:i:s',time());
        $sql = "SELECT email FROM user WHERE activation_token = '$token' AND activation_expires > '$dateCourant'";
        
        try{
            $res = ConnectionFactory::$db->prepare($sql);
            $res->execute();
            while ($data = $res->fetch()){
                    $mail = $data[0];
                    $activation = true;
            }
            if ($mail!==NULL){
                

                if ($activation==true){
                    $sql2 = "UPDATE user set activation = 1, activation_token=null WHERE activation_token = '$token' AND email = '$mail'";
                    $res2 = ConnectionFactory::$db->prepare($sql2);
                    $res2->execute();
                }else{
                    echo $mail;
                    $sql2 = "DELETE user WHERE email = '$mail'";
                    $res2 = ConnectionFactory::$db->prepare($sql2);
                    $res2->execute();
                }
            }else{
                throw new Exception();
            }
        }catch (\Exception){
            $activation=false;
        }
        

        return $activation;
    }

    public static function renewpswd($mdp,$email):string{
        $message = "Le mot de passe à bien était changé";
        $dateCourant = date('Y-m-d H:i:s',time());
        $sql = "SELECT email FROM user WHERE email='$email' AND renew_expires > '$dateCourant'";
        $res = ConnectionFactory::$db->prepare($sql);
        $res->execute();
        $data = $res->fetch();
        //echo $data."<br>ca doit marcher";
        if ($data!==NULL){
            //Longueur
            if (strlen($mdp) <10){
                $message = "Erreur : Mot de passe pas assez long (min : 10)";
            }

            $passhash = password_hash($mdp, PASSWORD_BCRYPT);

            $stmt = ConnectionFactory::$db->prepare("UPDATE user SET passwd='$passhash' WHERE email = ?");
            $stmt->bindParam(1, $email);
            $stmt->execute();

        }else{
            $message = "Page expirée !";
        }

        return $message;
    }
}