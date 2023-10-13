<?php

namespace app\models;

class ComputadorModel extends Connection
{
    public function buscarLaboratorio() {
        $conn = $this->connect();
        $sql = "select * from laboratorio";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }
}