<?php

/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 3/12/2017
 * Time: 12:54 PM
 */
class Account
{
    private $id;
    private $naam;
    private $gebnaam;
    private $niveau;
    private $email;
    private $aanmelddatum;

    /**
     * Account constructor.
     * @param $id
     * @param $naam
     * @param $gebnaam
     * @param $niveau
     * @param $email
     * @param $aanmelddatum
     */
    public function __construct($id, $naam, $gebnaam, $niveau, $email, $aanmelddatum)
    {
        $this->id = $id;
        $this->naam = $naam;
        $this->gebnaam = $gebnaam;
        $this->niveau = $niveau;
        $this->email = $email;
        $this->aanmelddatum = $aanmelddatum;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNaam()
    {
        return $this->naam;
    }

    /**
     * @return mixed
     */
    public function getGebnaam()
    {
        return $this->gebnaam;
    }

    /**
     * @return mixed
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getAanmelddatum()
    {
        return $this->aanmelddatum;
    }
}