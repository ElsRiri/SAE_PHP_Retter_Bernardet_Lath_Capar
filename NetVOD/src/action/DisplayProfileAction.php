<?php

namespace NetVOD\action;

use NetVOD\db\ConnectionFactory;

class DisplayProfileAction extends Action
{

    public function execute(): string
    {
        $str = "";
        if(isset($_SESSION['connexion'])){
            $email = $_SESSION['connexion']->email;
            $pdo = ConnectionFactory::makeConnection();
            $stmt = $pdo->prepare("Select * FROM user WHERE email = ?");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            $nom = $data['nom'];
            $prenom = $data['prenom'];
            $id_genre = $data['id_genre'];
            $stmt = $pdo->prepare("Select * FROM genre WHERE id_genre = ?");
            $stmt->bindParam(1, $id_genre);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (isset($data['libelle_genre'])){
                $genre = $data['libelle_genre'];
                if (is_null($nom)){
                    $str.= 'vous etes connecté, '.$_SESSION['connexion']->email;
                    $str.= 'Vous pouvez configurer d\'autres infos';
                } else {
                    $str.="Vous êtes connecté $prenom $nom sur l'email $email et $genre est votre genre préféré.";
                }
            }else{
                if (is_null($nom)){
                    $str.= 'vous etes connecté, '.$_SESSION['connexion']->email.". ";
                    $str.= 'Vous pouvez configurer d\'autres infos';
                } else {
                    $str.="Vous êtes connecté $prenom $nom sur l'email $email .";
                }
            }

            

        }else{
            $str.= 'vous etes pas connecté';
        }
        return $str;
    }
}