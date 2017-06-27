<?php

/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 3/12/2017
 * Time: 7:37 PM
 */
abstract class Page
{
    /**
     * @return string
     */
    public abstract function getName();

    /**
     * @return array
     */
    public abstract function getResources();

    /**
     * @return string
     */
    public abstract function getHtml();

    /**
     * @return void
     */
    public function echoJSON() {
        header('Content-Type: application/json');
        echo json_encode(array('page'=>$this->getName(), 'html'=>$this->getHtml(), 'resource'=>$this->getResources()));
    }
}