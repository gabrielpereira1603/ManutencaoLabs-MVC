<?php

namespace app\models;

class Crud extends Connection
{
    public function create()
    {
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);

        $conn = $this->connect();
        $sql = "insert into usuario values(default, :login, :senha, :nome, :email)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt;

    }
    public function read()
    {

    }
    public function update()
    {

    }
    public function delete()
    {

    }

    public function buscarLaboratorio()
    {
        $conn = $this->connect();
        $sql = "SELECT * FROM laboratorio";
    
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        $laboratorios = $stmt->fetchAll();
    
        foreach ($laboratorios as &$laboratorio) {
            $sql = "SELECT c.*, s.tiposituacao, l.codlaboratorio, l.numerolaboratorio
            FROM computador c
            LEFT JOIN situacao s ON c.codsituacao_fk = s.codsituacao
            LEFT JOIN laboratorio l ON c.codlaboratorio_fk = l.codlaboratorio
            WHERE c.codlaboratorio_fk = :codLaboratorio
            ORDER BY c.patrimonio ASC";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':codLaboratorio', $laboratorio['codlaboratorio']);
            $stmt->execute();
    
            $laboratorio['computadores'] = $stmt->fetchAll();
        }
    
        return $laboratorios;
    }

    public function getNiveisAcesso()
    {
        $conn = $this->connect();
    
        try {
            $stmt = $conn->prepare('SELECT * FROM nivel_acesso');
            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }
            $stmt->execute();
            $niveisAcessos = $stmt->fetchAll();
            return $niveisAcessos;
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function getComponentes()
    {
        $conn = $this->connect();

        try {
            $stmt = $conn->prepare('select * from componente');
            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }
            $stmt->execute();
            $componentes = $stmt->fetchAll();
            return $componentes;
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function getDetalhesReclamacao($codcomputador, $codLaboratorio) 
    {
        $conn = $this->connect();
        $sql = "SELECT
        ua.login AS login,
        ua.nome_usuario,
        r.codreclamacao AS codreclamacao,
        c.codcomputador AS codcomputador,
        c.patrimonio AS patrimonio,
        l.numerolaboratorio AS numerolaboratorio,
        r.datahora_reclamacao AS datahora_reclamacao,
        r.descricao AS descricao_reclamacao,
        s.tiposituacao AS situacao,
        GROUP_CONCAT(co.nome_componente) AS componentes
        FROM reclamacao r
        INNER JOIN usuario ua ON r.codusuario_fk = ua.codusuario
        INNER JOIN computador c ON r.codcomputador_fk = c.codcomputador
        INNER JOIN laboratorio l ON r.codlaboratorio_fk = l.codlaboratorio
        INNER JOIN situacao s ON c.codsituacao_fk = s.codsituacao
        LEFT JOIN reclamacao_componente rc ON r.codreclamacao = rc.codreclamacao_fk
        LEFT JOIN componente co ON rc.codcomponente_fk = co.codcomponente
        WHERE c.codcomputador = '$codcomputador' AND l.codlaboratorio = '$codLaboratorio' AND r.status = 'aberta'
        GROUP BY r.codreclamacao;";
    
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        $reclamacoes = $stmt->fetchAll();
        return $reclamacoes;
    }

    public function getUsuarios() 
    {
        $conn = $this->connect();

        try {
            $stmt = $conn->prepare('SELECT * FROM usuario WHERE nivel_acesso_fk > 1');
            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }
            $stmt->execute();
            $componentes = $stmt->fetchAll();
            return $componentes;
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }  

    public function getAllUsers() {
        $conn = $this->connect();

        try {
            $stmt = $conn->prepare('SELECT * FROM usuario');
            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }
            $stmt->execute();
            $componentes = $stmt->fetchAll();
            return $componentes;
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
    
}