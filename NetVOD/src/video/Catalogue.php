<?php

namespace NetVOD\video;

use NetVOD\db\ConnectionFactory;

class Catalogue
{
    protected array $series;

    public function __construct()
    {
        $this->series = [];
        $sql = "select serie.id, titre, descriptif, img, annee, date_ajout, genre.libelle_genre, public.libelle_public
        from serie, genre, public
        where serie.id_public=public.id
        and serie.no_genre=genre.id_genre";
        $res = ConnectionFactory::$db->prepare($sql);
        $res->execute();

        while ($data = $res->fetch()) {
            $s = new Serie($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7]);
            array_push($this->series, $s);
        }
    }

    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) {
            return $this->$at;
        }
        throw new  \NetVOD\Exception\InvalidPropertyNameException("$at: invalid property");

    }

    public function render(): string
    {
        $res = "<ul>";

        foreach ($this->series as $tS => $v) {
            $res .= <<<END
            <li><figure><img src='img/$v->img' alt='img de la série'><figcaption><a href="index.php?action=DisplaySerieAction&idserie=$v->id">$v->titre</a></figcaption></figure></li>
            END;
        }

        return $res . "</ul>";
    }

    public function tri($ordre, $attribut)
    {
        if ($attribut === "nb_episode") {
            if ($ordre === 'croissant') {
                usort($this->series, fn($a, $b) => sizeof($a->episode) <=> sizeof($b->episode));
            } elseif ($ordre === 'decroissant') {
                usort($this->series, fn($a, $b) => sizeof($b->episode) <=> sizeof($a->episode));
            }
        } elseif ($attribut === "note") {
            if ($ordre === 'croissant') {
                usort($this->series, fn($a, $b) => $a->calculnote() <=> $b->calculnote());
            } elseif ($ordre === 'decroissant') {
                usort($this->series, fn($a, $b) => $b->calculnote() <=> $a->calculnote());
            }
        } elseif ($ordre == 'croissant') {
            usort($this->series, fn($a, $b) => $a->$attribut <=> $b->$attribut);
        } elseif ($ordre === 'decroissant') {
            usort($this->series, fn($a, $b) => $b->$attribut <=> $a->$attribut);
        }

    }

    public function insertRecherche(string $search)
    {
        foreach ($this->series as $key => $serie) {
            if ((!str_contains($serie->titre, $search)) && (!str_contains($serie->descriptif, $search))) {
                unset($this->series[$key]);
            }
        }
    }

    public function filtre_genre(string $string){
        if ($string !=""){
            foreach($this->series as $key => $serie){
                if ($serie->genre!=$string) unset($this->series[$key]);
            }
        } 
    }

    public function filtre_public(string $string){
        if ($string != ""){
            foreach($this->series as $key => $serie){
                if ($serie->public!=$string) unset($this->series[$key]);
            }
        }
    }
}