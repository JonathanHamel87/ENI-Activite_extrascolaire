<?php


namespace App\Model;


class ListSortie
{
    private $campus;

    private $nomSortie;

    private $firstDate;

    private $secondeDate;

    private $bOrganisateur;

    private $bInscrit;

    private $bNonInscrit;

    private $bFini;

    /**
     * @return mixed
     */
    public function getCampus()
    {
        return $this->campus;
    }

    /**
     * @param mixed $campus
     */
    public function setCampus($campus): void
    {
        $this->campus = $campus;
    }

    /**
     * @return mixed
     */
    public function getNomSortie()
    {
        return $this->nomSortie;
    }

    /**
     * @param mixed $nomSortie
     */
    public function setNomSortie($nomSortie): void
    {
        $this->nomSortie = $nomSortie;
    }

    /**
     * @return mixed
     */
    public function getFirstDate()
    {
        return $this->firstDate;
    }

    /**
     * @param mixed $firstDate
     */
    public function setFirstDate($firstDate): void
    {
        $this->firstDate = $firstDate;
    }

    /**
     * @return mixed
     */
    public function getSecondeDate()
    {
        return $this->secondeDate;
    }

    /**
     * @param mixed $secondeDate
     */
    public function setSecondeDate($secondeDate): void
    {
        $this->secondeDate = $secondeDate;
    }

    /**
     * @return mixed
     */
    public function getBOrganisateur()
    {
        return $this->bOrganisateur;
    }

    /**
     * @param mixed $bOrganisateur
     */
    public function setBOrganisateur($bOrganisateur): void
    {
        $this->bOrganisateur = $bOrganisateur;
    }

    /**
     * @return mixed
     */
    public function getBInscrit()
    {
        return $this->bInscrit;
    }

    /**
     * @param mixed $bInscrit
     */
    public function setBInscrit($bInscrit): void
    {
        $this->bInscrit = $bInscrit;
    }

    /**
     * @return mixed
     */
    public function getBNonInscrit()
    {
        return $this->bNonInscrit;
    }

    /**
     * @param mixed $bNonInscrit
     */
    public function setBNonInscrit($bNonInscrit): void
    {
        $this->bNonInscrit = $bNonInscrit;
    }

    /**
     * @return mixed
     */
    public function getBFini()
    {
        return $this->bFini;
    }

    /**
     * @param mixed $bFini
     */
    public function setBFini($bFini): void
    {
        $this->bFini = $bFini;
    }














}