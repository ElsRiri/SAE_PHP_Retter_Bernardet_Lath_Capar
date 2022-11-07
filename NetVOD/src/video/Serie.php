<?php

namespace NetVOD\video;

class Serie
{
    protected String $titre,$descriptif,$date_ajout,$img;
    protected int $id,$annee;

    /**
     * @param int $id
     * @param String $titre
     * @param String $descriptif
     * @param String img
     * @param int $annee
     * @param String $date_ajout
     */
    public function __construct(int $id=0, string $titre="", string $descriptif="", string $img="", int $annee=0, string $date_ajout="" )
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->descriptif = $descriptif;
        $this->img = $img;
        $this->annee = $annee;
        $this->date_ajout = $date_ajout;
    }
}