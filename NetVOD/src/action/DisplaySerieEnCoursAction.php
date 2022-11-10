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
                $html.= "Liste episode de: ".$_SESSION['connexion']->email;


                //on récupères les id des series
                $seriesUtilisateur=[];
                $stmt = $connexion-> prepare("select distinct episode.serie_id from ep_vision inner join episode on ep_vision.id_ep = episode.id where ep_vision.id_user = ?");
                $stmt -> bindParam(1,$id_user);
                $stmt -> execute();
                while($resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC)){
                    $seriesUtilisateur[]=$resultatSet['serie_id'];
                }
                //ok
                foreach ($seriesUtilisateur as $key => $value){
                    //pour chaque serie vue
                    $stmt = $connexion-> prepare("select distinct * from serie where id = ?");
                    $value = str_replace("'",'',$value);
                    $stmt -> bindParam(1,$value);
                    $stmt -> execute();
                    while ($resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC)){
                        $serie = new Serie($resultatSet['id'],$resultatSet['titre'],$resultatSet['descriptif'],$resultatSet['img'],$resultatSet['annee'],$resultatSet['date_ajout']);

                        //on récupère les episodes vus avec les id
                        $episode_vu=[];
                        $stmt = $connexion -> prepare("select id_ep from ep_vision inner join episode on ep_vision.id_ep=episode.id where ep_vision.id_user =? and episode.serie_id =?;");
                        $stmt -> bindParam(1,$id_user);
                        $stmt -> bindParam(2,$resultatSet['id']);
                        $stmt -> execute();
                        while ($resultatSet2 = $stmt->fetch(\PDO::FETCH_ASSOC)){
                            $episode_vu[] = $resultatSet2['id_ep'];
                        }

                        if(sizeof($episode_vu) < sizeof($serie->episode)){
                            $html.=$serie->renderEnteteEpisode();
                            foreach ($episode_vu as $key => $value){
                                $html.= $serie->renderUnEpisode($value);
                            }
                        }


                    }
                }

            }


        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {


        }
        return $html;
    }
}