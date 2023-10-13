<?php

namespace app\models;

class LaboratorioModel extends Connection
{
public function buscarLaboratorio() {
    $conn = $this->connect();
    $sql = "SELECT * FROM laboratorio";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $laboratorios = $stmt->fetchAll();

    // Para cada laboratório, buscar os computadores associados
    foreach ($laboratorios as &$laboratorio) {
        $sql = "SELECT c.*, s.tiposituacao
        FROM computador c
        LEFT JOIN situacao s ON c.codsituacao_fk = s.codsituacao
        WHERE c.codlaboratorio_fk = :codLaboratorio
        ORDER BY c.patrimonio ASC";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codLaboratorio', $laboratorio['codlaboratorio']);
        $stmt->execute();

        $laboratorio['computadores'] = $stmt->fetchAll();
    }

    return $laboratorios;
}


}