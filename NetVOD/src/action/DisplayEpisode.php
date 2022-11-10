<?php

namespace NetVOD\action;

use NetVOD\video\Episode;

class DisplayEpisode extends Action
{

    public function __construct()
    {
        parent::__construct();
    }

    public function execute(): string
    {
        $html = "";
        if ($this->http_method == "GET") {
            if (isset($_SESSION['connexion'])) {
                $idEp = $_GET['idepisode'];
                $sql = "select * from episode where episode.id = ?";
                $stmt = \NetVOD\db\ConnectionFactory::$db->prepare($sql);
                $stmt->bindParam(1, $idEp);
                $stmt->execute();

                $data = $stmt->fetch(\PDO::FETCH_ASSOC);
                //int $id=0, int $numero=0, int $duree=0, int $serie_id=0 ,string $titre="", string $resume="",string $fichier=""
                $episode = new \NetVOD\video\Episode($data['id'], $data['numero'], $data['duree'], $data['serie_id'], $data['titre'], $data['resume'], $data['file']);
                $html = <<<END
                {$episode->render()}
                END;
                $id_user = $_SESSION['connexion']->getId();

                $this->ajoutEpisodeEnCours($episode, $id_user);


            } else {
                $html .= <<<END
                <p><strong>Vous ne pouvez pas afficher le catalogue sans vous connecter au préalable !</strong></p>
                END;
            }
        } elseif ($this->http_method == "POST") {
            if (isset($_SESSION['connexion'])) {
                $note = 0;
                $idep = 0;
                $com = "";
                foreach ($_POST as $t => $v) {
                    if ($t === "Note") {
                        $note = $v;
                    }
                }
                foreach ($_GET as $t => $v) {
                    if ($t == "idepisode") {
                        $idep = $v;
                    }
                }

                if (isset($_POST['Note'])) {
                    Episode::noterEpisode($idep, $note);
                } elseif (isset($_POST['ButtonCom'])) {
                    foreach ($_POST as $t => $v) {
                        if ($t == "text") {
                            $com = $v;
                        }
                    }
                    Episode::commenter($idep, $com);
                }
                $idEp = $_GET['idepisode'];
                $sql = "select * from episode where episode.id = ?";
                $stmt = \NetVOD\db\ConnectionFactory::$db->prepare($sql);
                $stmt->bindParam(1, $idEp);
                $stmt->execute();

                $data = $stmt->fetch(\PDO::FETCH_ASSOC);
                $episode = new \NetVOD\video\Episode($data['id'], $data['numero'], $data['duree'], $data['serie_id'], $data['titre'], $data['resume'], $data['file']);

                $html = <<<END
                {$episode->render()}
                END;
            } else {
                $html .= <<<END
                <p><strong>Vous ne pouvez pas afficher le catalogue sans vous connecter au préalable !</strong></p>
                END;
            }
        }
        return $html;
    }

    public function ajoutEpisodeEnCours(Episode $episode, string $id_user)
    {
        try {
            $id = $episode->id;

            $connexion = \NetVOD\db\ConnectionFactory::makeConnection();
            $stmt = $connexion->prepare("insert into ep_vision values('$id','$id_user',null,null)");
            $stmt->execute();
        } catch (\PDOException $ignored) {

        }


    }

}