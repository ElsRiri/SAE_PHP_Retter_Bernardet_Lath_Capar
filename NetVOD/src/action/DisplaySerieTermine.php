<?php

namespace NetVod\action;

use NetVOD\db\ConnectionFactory;
use NetVOD\video\Catalogue;
use NetVOD\video\Serie;

class DisplaySerieTermine extends \NetVOD\action\Action
{

    public function execute(): string
    {
        $html = "";
        if ($this->http_method == "GET") {
            $id_user = $_SESSION['connexion']->getId();
            $seriesUtilisateur = [];
            $connection = ConnectionFactory::makeConnection();
            //on recupere tous les series
            $catalogue = new Catalogue();
            $listeSerie = $catalogue->series;

            foreach ($listeSerie as $key => $value) {
                $id_serie = $value->id;
                $stmt = $connection->prepare("select count(*) as nombre_episode_vu from ep_vision inner join episode on ep_vision.id_ep = episode.id where ep_vision.id_user = ? and episode.serie_id = ?");
                $stmt->bindParam(1, $id_user);
                $stmt->bindParam(2, $id_serie);
                $stmt->execute();
                $resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC);
                $nb_episode_serie_vu = $resultatSet['nombre_episode_vu']; //nombre d'episode que l'utilisateur a vu

                $stmt = $connection->prepare("select count(*) as nombre_episode_serie from episode inner join serie on episode.serie_id = serie.id  where serie.id =? ");//nombre d'episode dans la série
                $stmt->bindParam(1, $id_serie);
                $stmt->execute();
                $resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC);
                $nb_episode_serie = $resultatSet['nombre_episode_serie'];
                // si tous les épisodes ont été vu
                if ($nb_episode_serie_vu == $nb_episode_serie) {;
                    $stmt = $connection->prepare("select  * from serie where id = ?");
                    $stmt->bindParam(1, $id_serie);
                    $stmt->execute();
                    $resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC);
                    $series = new Serie($resultatSet['id'], $resultatSet['titre'], $resultatSet['descriptif'], $resultatSet['img'], $resultatSet['annee'], $resultatSet['date_ajout']);
                    $seriesUtilisateur[]=$series;

                }

            }
            //affichage serie
            foreach ($seriesUtilisateur as $key => $value){
                $html.=$value->render();

            }

        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {

        }
        return $html;

    }


}