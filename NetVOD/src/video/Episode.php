<?php

namespace NetVOD\video;

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

        $html = <<<END
        <img src="img/$img" alt="img de la série">
        <h4> $this->titre </h4>
        <p>$this->resume<br>durée : $this->duree</p>
        END;
        return $html;
    }
}
