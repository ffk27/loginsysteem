<?php

/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 3/12/2017
 * Time: 12:54 PM
 */
class Gebruiker
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $naam;
    private $gebnaam;
    private $niveau;
    private $email;
    private $aanmelddatum;

    public function __construct($id, $naam, $gebnaam, $niveau, $email, $aanmelddatum)
    {
        $this->id = $id;
        $this->naam = $naam;
        $this->gebnaam = $gebnaam;
        $this->niveau = $niveau;
        $this->email = $email;
        $this->aanmelddatum = $aanmelddatum;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNaam()
    {
        return $this->naam;
    }

    public function getGebnaam()
    {
        return $this->gebnaam;
    }

    public function getNiveau()
    {
        return $this->niveau;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAanmelddatum()
    {
        return $this->aanmelddatum;
    }
}