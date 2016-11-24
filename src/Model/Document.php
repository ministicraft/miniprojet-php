<?php
/**
 * Created by IntelliJ IDEA.
 * User: world
 * Date: 24/11/2016
 * Time: 15:36
 */

namespace App\Model;


class Document
{
    private $id;
    private $rang;
    private $promo;
    private $libelle;
    private $fichier;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * @param mixed $rang
     */
    public function setRang($rang)
    {
        $this->rang = $rang;
    }

    /**
     * @return mixed
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * @param mixed $promo
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;
    }

    /**
     * @return mixed
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * @param mixed $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * @return mixed
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * @param mixed $fichier
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;
    }
}