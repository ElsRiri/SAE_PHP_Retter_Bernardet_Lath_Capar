<?php

namespace NetVOD\video;

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
        $html = <<<END
        <h4>Titre : $this->titre</h4>
        <p>Description : $this->descriptif<p>
        <img src="img/$this->img" alt ="img de la série"></img>
        <br><i> Année : $this->annee - Ajoutée sur la plateforme le $this->date_ajout</i>
        END;

        foreach ($this->episode as $value){
            $html .= <<<END
            <li> <a href = "index.php?action=DisplayEpisode&idepisode=$value->id">$value->numero - $value->titre</a>
            END;
        }
        return $html;
    }
    
}