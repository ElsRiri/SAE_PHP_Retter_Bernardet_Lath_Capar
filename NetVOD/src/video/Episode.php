<?php

namespace NetVOD\video;

use NetVOD\db\ConnectionFactory;

class Episode
{
    protected int $id,$numero,$duree,$serie_id;
    protected String $titre,$resume,$fichier;

    /**
     * @param int $id
     * @param int $numero
     * @param int $duree
     * @param int $serie_id
     * @param String $titre
     * @param String $resume
     * @param String $fichier
     */
    public function __construct(int $id=0, int $numero=0, int $duree=0, int $serie_id=0 ,string $titre="", string $resume="",string $fichier="")
    {
        $this->id = $id;
        $this->numero = $numero;
        $this->duree = $duree;
        $this->serie_id = $serie_id;
        $this->titre = $titre;
        $this->resume = $resume;
        $this->fichier = $fichier;
    }

    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) {
            return $this->$at;
        }
        throw new  \NetVOD\Exception\InvalidPropertyNameException("$at: invalid property");

    }
    

    
    function render():string{
        $sql="select img from serie, episode 
        where episode.id=?
        and serie.id= ?
        and serie.id=episode.serie_id";

        $stmt = \NetVOD\db\ConnectionFactory::$db->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->bindParam(2, $this->serie_id);
        $stmt->execute();
        $resultset = $stmt->fetch();
        $img = $resultset[0];

        $sql2="select file from serie, episode 
        where episode.id=?
        and serie.id= ?
        and serie.id=episode.serie_id";
        $stmt = \NetVOD\db\ConnectionFactory::$db->prepare($sql2);
        $stmt->bindParam(1, $this->id);
        $stmt->bindParam(2, $this->serie_id);
        $stmt->execute();
        $resultset = $stmt->fetch();
        $vid = $resultset[0];

        $html = <<<END
        <img src="img/$img" alt="img de la série">
        <h4> Titre : $this->titre </h4>
        <video controls width="500">
            <source src="video/$vid" type="video/mp4">
        </video>
        <p> Résumé : $this->resume<br> Durée : $this->duree</p>
        <form id="f1" method="post" action="index.php?action=DisplayEpisode&idepisode=$this->id">
            <label>Note : </label>
            <input value="5" name="Note" type="number" max="5" min="1" placeholder="<entre 1 et 5>">
            <input value="Valider" name="Button" type="submit" /><br>
        </form>
        <form id="f2" method="post" action="index.php?action=DisplayEpisode&idepisode=$this->id">
            <p>commentaire : </p><textarea maxlength="2500" rows = '10' cols = '120' name = 'text' class ="jpp">Votre commentaire !</textarea><br><br>
            <input value="Envoyer" name="ButtonCom" type="submit" /><br
        </form>
        END;
        return $html;
    }

    public static function noterEpisode($idep,$note):void{
        $co = ConnectionFactory::makeConnection();
        $u = $_SESSION['connexion'];
        $id = $u->getId();
        $email = $u->email;
        $stmt = $co->prepare('UPDATE ep_vision SET note=? WHERE id_ep=? AND id_user=? ');
        $stmt->bindParam(1, $note);
        $stmt->bindParam(2, $idep);
        $stmt->bindParam(3, $id);
        
        $stmt->execute();
    }

    public static function commenter($idep,$commentaire):void{
        $co = ConnectionFactory::makeConnection();
        $u = $_SESSION['connexion'];
        $id = $u->getId();
        $email = $u->email;
        $stmt = $co->prepare('UPDATE ep_vision SET commentaire=? WHERE id_ep=? AND id_user=? ');
        $stmt->bindParam(1, $commentaire);
        $stmt->bindParam(2, $idep);
        $stmt->bindParam(3, $id);
        
        $stmt->execute();
    }

    public static function verifierNote($idep,$user):bool{
        $trouver=false;
        $co = ConnectionFactory::makeConnection();

        $stmt = $co->prepare("SELECT id_ep FROM ep_vision WHERE id_user=? AND note!=NULL");
        $stmt->bindParam(1,$user);
        $stmt->execute();

        while ($data = $stmt->fetch()){
            if ($idep==$data[0]){
                $trouver=true;
            }
        }

        return $trouver;
    }

    public static function verifierCom($idep,$user):bool{
        $trouver=false;
        $co = ConnectionFactory::makeConnection();

        $stmt = $co->prepare("SELECT id_ep FROM ep_vision WHERE id_user=? AND commentaire!=NULL");
        $stmt->bindParam(1,$user);
        $stmt->execute();

        while ($data = $stmt->fetch()){
            if ($idep==$data[0]){
                $trouver=true;
            }
        }

        return $trouver;
    }

}
