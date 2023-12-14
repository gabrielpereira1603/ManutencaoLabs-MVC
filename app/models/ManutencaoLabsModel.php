<?php

namespace app\models;

class ManutencaoLabsModel extends Connection {

    public function BuscarPc($codLaboratorio) {
        $conn = $this->connect();

        // Realize a consulta SQL para buscar os dados
        $sql = "SELECT * FROM computador WHERE codlaboratorio_fk = :codLaboratorio";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codLaboratorio', $codLaboratorio);
        $stmt->execute();
        $computadores = $stmt->fetchAll();


        return($computadores);
    }

    public function deleteLab($nomeLaboratorio) {
        $conn = $this->connect();

        try {
            $stmt = $conn->prepare('DELETE FROM laboratorio WHERE numerolaboratorio = (:nomelaboratorio)');
            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }
    
            $stmt->bindParam(':nomelaboratorio', $nomeLaboratorio);
    
            $stmt->execute();
    
            return true;
        } catch (\PDOException $e) {
            error_log("Erro de PDO: " . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            error_log("Outro erro: " . $e->getMessage());
            return false;
        }
    }

    public function createLab($nomeLaboratorio) {
        $conn = $this->connect();
    
        try {
            $stmt = $conn->prepare('INSERT INTO laboratorio (numerolaboratorio) VALUES (:nomelaboratorio)');
            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }
    
            $stmt->bindParam(':nomelaboratorio', $nomeLaboratorio);
    
            $stmt->execute();
    
            return true;
        } catch (\PDOException $e) {
            error_log("Erro de PDO: " . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            error_log("Outro erro: " . $e->getMessage());
            return false;
        }
    }

    public function createPc($patrimonio, $nomeLaboratorio) {
        $conn = $this->connect();
    
        try {
            $stmt = $conn->prepare('INSERT INTO computador (patrimonio, codlaboratorio_fk, codsituacao_fk) VALUES (:patrimonio, :codlaboratorio, "1")');
            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }
    
            $stmt->bindParam(':patrimonio', $patrimonio);
            $stmt->bindParam(':codlaboratorio', $nomeLaboratorio);
    
            $stmt->execute();
    
            return true;
        } catch (\PDOException $e) {
            error_log("Erro de PDO: " . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            error_log("Outro erro: " . $e->getMessage());
            return false;
        }
    }

    public function deletePc($patrimonio, $nomeLaboratorio) {
        $conn = $this->connect();
    
        try {
            $stmt = $conn->prepare('DELETE FROM computador WHERE patrimonio = (:patrimonio)');
            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }
    
            $stmt->bindParam(':patrimonio', $patrimonio);    
            $stmt->execute();
    
            return true;
        } catch (\PDOException $e) {
            error_log("Erro de PDO: " . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            error_log("Outro erro: " . $e->getMessage());
            return false;
        }
    }

    public function createComp($componente) {
        $conn = $this->connect();
    
        try {
            $stmt = $conn->prepare('INSERT INTO componente (nome_componente) VALUES (:componente)');
            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }
    
            $stmt->bindParam(':componente', $componente);    
            $stmt->execute();
    
            return true;
        } catch (\PDOException $e) {
            error_log("Erro de PDO: " . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            error_log("Outro erro: " . $e->getMessage());
            return false;
        }
    }

    public function deleteComp($componente) {
        $conn = $this->connect();
    
        try {
            $stmt = $conn->prepare('DELETE FROM componente WHERE nome_componente = (:componente)');
            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }
    
            $stmt->bindParam(':componente', $componente);    
            $stmt->execute();
    
            return true;
        } catch (\PDOException $e) {
            error_log("Erro de PDO: " . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            error_log("Outro erro: " . $e->getMessage());
            return false;
        }
    }
    
}
    
