<?php

//parent class for all managers
abstract class AbstractEntityManager
{
    protected DBManager $db;

    public function __construct()
    {
        $this->db = DBManager::getInstance();
    }
}
