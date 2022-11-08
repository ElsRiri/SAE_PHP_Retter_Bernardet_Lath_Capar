<?php

namespace NetVOD\action;

use NetVOD\db\ConnectionFactory;
use NetVOD\video\Serie;

class DisplaySerieEnCoursAction extends \NetVOD\action\Action
{

    public function execute(): string
    {
        $html = "";
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (isset($_SESSION['connexion'])){
                $email_user = $_GET['connexion']['email'];
                $connexion = ConnectionFactory::makeConnection();
                $stmt = $connexion-> prepare("select id from user where email = ?");
                $stmt -> bindParam(1,$email_user);
                $stmt -> execute();
                $resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC);
                $id_user = $resultatSet['id'];

                $stmt = $connexion-> prepare("select id from serie where id = ?");
                $stmt -> bindParam(1,$id_user);
                $stmt -> execute();
                $html.= "Liste episode de: ".$_SESSION['connexion']['email'];
                while ($resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC)){
                    $serie = new Serie($resultatSet['id'],$resultatSet['titre'],$resultatSet['descriptif'],$resultatSet['img'],$resultatSet['annee'],$resultatSet['date_ajout']);
                    $html.= $serie->render();
                };



            }


        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {


        }
        return $html;
    }
}