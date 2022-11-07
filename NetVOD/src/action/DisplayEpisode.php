<?php

namespace NetVOD\action;

class DisplayEpisode extends Action {

    public function __construct(){
        parent::__construct();
    }

    public function execute() : string{
        $html = "";
        if ($this->http_method=="GET") {
            if (!isset($_SESSION['connexion'])){
                $idEp = $_GET['idepisode'];
                $sql = "select * from episode where episode.id = ?";
                $stmt = \NetVOD\db\ConnectionFactory::$db->prepare($sql);
                $stmt->bindParam(1, $idEp);
                $stmt->execute();

                $data = $stmt->fetch(\PDO::FETCH_ASSOC);
                //int $id=0, int $numero=0, int $duree=0, int $serie_id=0 ,string $titre="", string $resume="",string $fichier=""
                $episode = new \NetVOD\video\Episode($data['id'],$data['numero'],$data['duree'],$data['serie_id'], $data['titre'], $data['resume'], $data['file']);

                $html = <<<END
                {$episode->render()}
                END;
            }else{
                $html .= <<<END
                <p><strong>Vous ne pouvez pas afficher le catalogue sans vous connecter au préalable !</strong></p>
                END;
            }
            return $html;
        }
    }

}