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
            $serie = null;
            if(count($resultatSet)>=1){
                $serie = new Serie($resultatSet['id'],$resultatSet['titre'],$resultatSet['descriptif'],$resultatSet['img'],$resultatSet['annee'],$resultatSet['date_ajout']);
            }
            $s = <<<END
            {$serie->render()}
            END;
            
        } elseif ($_SERVER['REQUEST_METHOD'] == "POST"){
            
            $id=0;
            foreach ($_POST as $t => $v){
                $id=$v;
            }
            if (!Serie::verifier($id,$_SESSION['connexion']->getID())){
                Serie::ajouterPreference($id);
            }
            

            $idSerie = $_GET['idserie'];
            $connexion = ConnectionFactory::makeConnection();
            $stmt = $connexion -> prepare("SELECT * from serie WHERE id = ?");
            $stmt -> bindParam(1,$idSerie);
            $stmt -> execute();
            $resultatSet = $stmt->fetch(\PDO::FETCH_ASSOC);
            $serie = null;
            if(count($resultatSet)>=1){
                $serie = new Serie($resultatSet['id'],$resultatSet['titre'],$resultatSet['descriptif'],$resultatSet['img'],$resultatSet['annee'],$resultatSet['date_ajout']);
            }
            $s = <<<END
            {$serie->render()}
            END;


        }else{
            $s .= <<<END
            <p><strong>Vous ne pouvez pas afficher le catalogue sans vous connecter au préalable !</strong></p>
            END;
        }
        return $s;
    }
}