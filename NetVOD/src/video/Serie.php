<?php

namespace NetVOD\video;

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
        $this->episode = $ep;

        if ($ep->count() == 0) {
            $connexion = \NetVOD\db\ConnectionFactory::makeConnection();
            $stmt = $connexion->prepare("SELECT * FROM EPISODE WHERE serie_id = ? ORDER BY NUMERO ASC");
            $stmt->bindParam(1, $this -> id);
            $stmt->execute();
            $listeEpisode = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $listeEpisode[] = new Episode($row['id'], $row['numero'], $row['duree'], $this->id, $row['titre'], $row['resume'], $row['file']);
            }
            $this->ep = $listeEpisode;
        }



    }

    public function __get(string $at): mixed
    {
        if (property_exists($this, $at)) {
            return $this->$at;
        }
        throw new InvalidPropertyNameException("$at: invalid property");

    }
}