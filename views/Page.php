<?php

/**
 * Created by PhpStorm.
 * User: Gebruiker
 * Date: 3/12/2017
 * Time: 7:37 PM
 */
interface Page
{
    /**
     * @return string
     */
    public function name();

    /**
     * @return array
     */
    public function resource();

    /**
     * @return string
     */
    public function html();
}