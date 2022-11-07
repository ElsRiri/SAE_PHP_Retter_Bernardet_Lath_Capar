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
            $stmt = $connexion -> prepare("SELECT * from SERIE WHERE id = ?");
            $stmt -> bind(1,$idSerie);
            $stmt -> exec();
            $resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC);
            $serie=null;
            if($resultatSet->count() == 1){
                $serie = new Serie($resultatSet['id'],$resultatSet['titre'],$resultatSet['descriptif'],$resultatSet['img'],$resultatSet['annee'],$resultatSet['date_ajout']);
            }
            $s = <<<END

END;
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {

        }
        return $s;
    }
}