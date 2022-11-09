<?php

namespace NetVOD\video;

use NetVOD\db\ConnectionFactory;
use \NetVOD\Exception\InvalidPropertyNameException;

class Serie
{
    protected string $titre, $descriptif, $date_ajout, $img;
    protected int $id, $annee;
    protected array $episode;

    /**
     * @param int $id
     * @param String $titre
     * @param String $descriptif
     * @param String img
     * @param int $annee
     * @param String $date_ajout
     * @param array $ep
     */
    public function __construct(int $id = 0, string $titre = "", string $descriptif = "", string $img = "", int $annee = 0, string $date_ajout = "", array $ep = [])
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->descriptif = $descriptif;
        $this->img = $img;
        $this->annee = $annee;
        $this->date_ajout = $date_ajout;
        $this->episode = $this->insertEpisode();

    }
    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) {
            return $this->$at;
        }
        throw new  \NetVOD\Exception\InvalidPropertyNameException("$at: invalid property");

    }

    public function __set(string $at,mixed $val):void {
        if ( property_exists ($this, $at) ) {
            $this->$at = $val;
        } else throw new Exception ("$at: invalid property");
    }
    public function insertEpisode():array{
        $sql = "select * from episode where episode.serie_id = ?";
        $stmt = \NetVOD\db\ConnectionFactory::$db->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $tab[]=new \NetVOD\video\Episode($data['id'], $data['numero'], $data['duree'], $data['serie_id'], $data['titre'], $data['resume'], $data['file']);
        }
        return $tab;
    }
    

    public function render():string {
        foreach ($_GET as $t => $v){
            if ($t==="action"){
                $display=$v;
            }
            if ($t==="idserie"){
                $idS=$v;
            }else{
                $idS="";
            }
        }
        $html = <<<END
        <h4>Titre : $this->titre</h4>
        <p>Description : $this->descriptif<p>
        <br> Note : {$this->calculnote()}/5
        <br> <a href = "index.php?action=DisplayCommentaire&idserie=$this->id"> Voir les commentaires </a>
        <br>
        <img src="img/$this->img" alt ="img de la série"></img>
        <br><i> Année : $this->annee - Ajoutée sur la plateforme le $this->date_ajout</i>
        <br>
        <form method="post" action="index.php?action=$display&idserie=$idS">
            <input type="submit" name="$this->id"
                    class="button" value="Favorie" />
        </form>

        END;

        foreach ($this->episode as $value){
            $html .= <<<END
            <li> <a href = "index.php?action=DisplayEpisode&idepisode=$value->id">$value->numero - $value->titre</a>
            END;
        }
        return $html;
    }

    public static function ajouterPreference($serie)
    {
        $co = ConnectionFactory::makeConnection();
        $email = $_SESSION['connexion']->email;
        $stmtid = $co->prepare('SELECT * FROM user WHERE email = ?');
        $stmtid->bindParam(1,$email);
        $stmtid->execute();
        $dataid = $stmtid->fetch(\PDO::FETCH_ASSOC);
        $id = $dataid['id'];
        $stmt = $co->prepare('INSERT INTO preference VALUES (?, ?)');
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $serie);
        $stmt->execute();
    }

    public static function verifier($serie,$user):bool{
        $trouver=false;
        $co = ConnectionFactory::makeConnection();

        $stmt = $co->prepare("SELECT id_serie FROM preference WHERE id_user=?");
        $stmt->bindParam(1,$user);
        $stmt->execute();

        while ($data = $stmt->fetch()){
            if ($serie==$data[0]){
                $trouver=true;
            }
        }

        return $trouver;
    }

    public function calculnote(){
        $sql="select AVG (ep_vision.note)
        from serie, episode, ep_vision
        where serie.id=episode.serie_id
        and episode.id=ep_vision.id_ep
        and serie.id=?";

        $stmt = ConnectionFactory::$db->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $data = $stmt->fetch();
        
        if (isset($data[0])) return round($data[0],2);
        else return "?";
    }
    

    public function liste_commentaire(){
        $string ="Liste des commentaires: <br>";
        $sql = "select user.email ,commentaire, episode.numero  
        from serie, ep_vision, episode, user
        where serie.id=episode.serie_id
        and ep_vision.id_ep=episode.id
        and user.id=ep_vision.id_user
        and commentaire<>'NULL'
        and serie.id=?";

        $stmt = ConnectionFactory::$db->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

            while ($data = $stmt->fetch()){
                $string.="<br><font color='0000FF'> $data[0] </font>: <i>$data[1]</i> (episode n° $data[2]) <br>";
            } 
        if ($string == "Liste des commentaires: <br>") $string .= "<i>pas de commentaire pour le moment</i><br>";

        $string.= <<<END
        <a href = "index.php?action=DisplaySerieAction&idserie=$this->id"> retour </a>
        END;

        return $string;
    }




}