<?php

namespace NetVOD\action;

use NetVOD\action\Action;
use NetVOD\db\ConnectionFactory;
use NetVOD\video\Serie;

class DisplaySerieAction extends Action
{

    public function execute(): string
    {
        $s = "";
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $idSerie = $_GET['idserie'];
            $connexion = ConnectionFactory::makeConnection();
            $stmt = $connexion -> prepare("SELECT * from serie WHERE id = ?");
            $stmt -> bindParam(1,$idSerie);
            $stmt -> execute();
            $resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC);
            $serie=null;
            if(count($resultatSet) != 0){
                $serie = new Serie($resultatSet['id'],$resultatSet['titre'],$resultatSet['descriptif'],$resultatSet['img'],$resultatSet['annee'],$resultatSet['date_ajout']);
                //$serie->insertEpisode();
                foreach ($serie->episode as $value) print $value->titre;
           }
           $string = $serie->render();
            $s = <<<END
           $string
END;
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {

        }
        return $s;
    }
}