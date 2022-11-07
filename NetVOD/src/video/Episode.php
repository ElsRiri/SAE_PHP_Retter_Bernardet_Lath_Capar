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
    public function __construct(int $id=0, int $numero=0, int $duree=0, int $serie_id,string $titre="", string $resume="",string $fichier="")
    {
        $this->id = $id;
        $this->numero = $numero;
        $this->duree = $duree;
        $this->serie_id = $serie_id;
        $this->titre = $titre;
        $this->resume = $resume;
        $this->fichier = $fichier;
    }

}