<?php

namespace app\models;

abstract class Connection
{
    private $bdname = 'mysql:host=roundhouse.proxy.rlwy.net;dbname=railway';
    private $user = 'root';
    private $pass = 'fCaecg2A3eFHHDghbeE-fDAA51-BABBG';

    protected function connect()
    {
        try {
            $conn = new \PDO($this->bdname, $this->user, $this->pass);
            $conn->exec("set names utf8");
            return $conn; // Retorne a instância do PDO
        } catch (\PDOException $erro) {
            echo $erro->getMessage();
        }
    }
}