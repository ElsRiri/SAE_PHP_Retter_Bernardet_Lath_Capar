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
                $email_user = $_SESSION['connexion']-> email;
                $connexion = ConnectionFactory::makeConnection();
                $stmt = $connexion-> prepare("select id from user where email = ?");
                $stmt -> bindParam(1,$email_user);
                $stmt -> execute();
                $resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC);
                $id_user = $resultatSet['id'];

                //on récupères les id des series
                $seriesUtilisateur=[];
                $stmt = $connexion-> prepare("select distinct episode.serie_id from ep_vision inner join episode on ep_vision.id_ep = episode.id where ep_vision.id_user = ?");
                $stmt -> bindParam(1,$id_user);
                $stmt -> execute();
                while($resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC)){
                    $seriesUtilisateur[]=$resultatSet['serie_id'];
                }

                foreach ($seriesUtilisateur as $key => $value){
                    $stmt = $connexion-> prepare("select distinct * from serie where id = ?");
                    $value = str_replace("'",'',$value);
                    $stmt -> bindParam(1,$value);
                    $stmt -> execute();
                    $html.= "Liste episode de: ".$_SESSION['connexion']->email;
                    while ($resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC)){
                        $serie = new Serie($resultatSet['id'],$resultatSet['titre'],$resultatSet['descriptif'],$resultatSet['img'],$resultatSet['annee'],$resultatSet['date_ajout']);
                        $html.= $serie->render();
                    };
                }

            }


        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {


        }
        return $html;
    }
}