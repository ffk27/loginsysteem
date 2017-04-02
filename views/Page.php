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
    public abstract function name();

    /**
     * @return array
     */
    public abstract function resource();

    /**
     * @return string
     */
    public abstract function html();

    /**
     * @return string
     */
    public function pagejson() {
        header('Content-Type: application/json');
        echo json_encode(array('page'=>$this->name(), 'html'=>$this->html(), 'resource'=>$this->resource()));
    }
}