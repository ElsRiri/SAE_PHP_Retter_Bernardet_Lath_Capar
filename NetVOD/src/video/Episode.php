<?php

namespace NetVOD\video;

class Episode
{
    protected int $numero,$duree;
    protected String $image,$titre;

    /**
     * @param int $numero
     * @param int $duree
     * @param String $image
     * @param String $titre
     */
    public function __construct( string $titre="", int $numero=0, int $duree=0, string $image="")
    {
        $this->numero = $numero;
        $this->duree = $duree;
        $this->image = $image;
        $this->titre = $titre;
    }

}