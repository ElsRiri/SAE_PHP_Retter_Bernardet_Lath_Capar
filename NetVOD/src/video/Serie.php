<?php

namespace NetVOD\video;

class Serie
{
    protected String $titre,$genre,$publicVise,$descriptif,$dateAjoutPlateforme;
    protected int $annee,$nbEpisode;

    /**
     * @param String $titre
     * @param String $genre
     * @param String $publicVise
     * @param String $descriptif
     * @param String $dateAjoutPlateforme
     * @param int $annee
     * @param int $nbEpisode
     */
    public function __construct(string $titre="", string $genre="", string $publicVise="", string $descriptif="", string $dateAjoutPlateforme="", int $annee=0, int $nbEpisode=0)
    {
        $this->titre = $titre;
        $this->genre = $genre;
        $this->publicVise = $publicVise;
        $this->descriptif = $descriptif;
        $this->dateAjoutPlateforme = $dateAjoutPlateforme;
        $this->annee = $annee;
        $this->nbEpisode = $nbEpisode;
    }
}