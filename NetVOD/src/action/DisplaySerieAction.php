<?php

namespace NetVOD\action;

use NetVOD\action\Action;
use NetVOD\db\ConnectionFactory;
use NetVOD\video\Serie;

use function PHPSTORM_META\type;

class DisplaySerieAction extends Action
{

    public function execute(): string
    {
        $s = "";
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $idSerie = $_GET['idserie'];
            $connexion = ConnectionFactory::makeConnection();
            $stmt = $connexion->prepare("select serie.id, titre, descriptif, img, annee, date_ajout, genre.id_genre,public.id 
            from serie, genre, public
            where serie.id_public=public.id
            and serie.no_genre=genre.id_genre
            and serie.id=?");
            $stmt->bindParam(1, $idSerie);
            $stmt->execute();
            $data = $stmt->fetch();
            $serie = null;
            if (count($data) >= 1) {
                $serie = new Serie($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7]);
            }
            $s = <<<END
            {$serie->render()}
            END;

        } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = 0;
            foreach ($_POST as $t => $v) {
                $id = $t;
            }

            //on regarde dans le post si on doit
            if (in_array("Ajouter / Retirer des Favoris",$_POST)){
                if (Serie::checkPreference($id)) {
                    Serie::retirerPreference($id);
                } else {
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
                $dernier_episode = Serie::dernierEpisodeEnCours($id);
                $s.=$dernier_episode->render();

            }


        }else{
            $s .= <<<END
            <p><strong>Vous ne pouvez pas afficher le catalogue sans vous connecter au préalable !</strong></p>
            END;
        }
        return $s;
    }
}