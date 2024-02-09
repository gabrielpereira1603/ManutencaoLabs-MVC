<?php

namespace app\models;

class ReclamacaoModel extends Connection
{
    public function inserirReclamacao($codComputador, $patrimonio, $codLaboratorio, $reclamacao, $componentesSelecionados)
    {
        $conn = $this->connect();
    
        $nomeAluno = $_SESSION['nomeadmin'];
        $codUsuario = $_SESSION['codusuario'];
    
        $sql = "SELECT codlaboratorio_fk FROM computador WHERE patrimonio = :patrimonio AND codlaboratorio_fk = :codLaboratorio";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':patrimonio', $patrimonio);
        $stmt->bindParam(':codLaboratorio', $codLaboratorio);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if (!$row) {
            return false;
        }
    
        $sql = "INSERT INTO reclamacao (descricao, status, datahora_reclamacao, codcomputador_fk, codlaboratorio_fk, codusuario_fk) VALUES (:reclamacao, 'aberta', NOW(), :codComputador, :codLaboratorio, :codUsuario)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':reclamacao', $reclamacao);
        $stmt->bindParam(':codComputador', $codComputador);
        $stmt->bindParam(':codLaboratorio', $codLaboratorio);
        $stmt->bindParam(':codUsuario', $codUsuario);
        $stmt->execute();
        
        $codReclamacao = $conn->lastInsertId();
    
        $sql = "UPDATE computador SET codsituacao_fk = 2 WHERE codcomputador = :codComputador";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codComputador', $codComputador);
        $stmt->execute();
    
        foreach ($componentesSelecionados as $componente) {
            $sql = "INSERT INTO reclamacao_componente (codreclamacao_fk, codcomponente_fk) VALUES (:codReclamacao, :codComponente)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':codReclamacao', $codReclamacao);
            $stmt->bindParam(':codComponente', $componente, \PDO::PARAM_INT);
            $stmt->execute();
        }
    
        return true;
    }
    
    public function buscarReclamacao($codreclamacao, $numeroLaboratorio, $patrimonio)
    {
        $conn = $this->connect();
    
        $sql = "SELECT 
            r.codreclamacao,
            r.descricao,
            l.numerolaboratorio,
            u.nome_usuario,
            c.patrimonio,
            c.codcomputador,
            GROUP_CONCAT(co.nome_componente) AS componentes,
            s.codsituacao
        FROM reclamacao r
        JOIN laboratorio l ON r.codlaboratorio_fk = l.codlaboratorio
        JOIN usuario u ON r.codusuario_fk = u.codusuario 
        JOIN computador c ON r.codcomputador_fk = c.codcomputador
        JOIN situacao s ON c.codsituacao_fk = s.codsituacao
        LEFT JOIN reclamacao_componente rc ON r.codreclamacao = rc.codreclamacao_fk
        LEFT JOIN componente co ON rc.codcomponente_fk = co.codcomponente
        WHERE r.codreclamacao = :codreclamacao
        GROUP BY r.codreclamacao, l.numerolaboratorio, u.nome_usuario, c.patrimonio
        LIMIT 0, 25;";
    
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codreclamacao', $codreclamacao);
        $stmt->execute();
    
        $result = $stmt->fetchAll();
    
        return $result;
    }

    public function deleteReclamacao($codcomputador, $codreclamacao, $descricao, $componentesString)
    {
        $conn = $this->connect();

        // Lógica para excluir a reclamação e seus componentes associados
        $sqlDeleteComponentes = "DELETE FROM reclamacao_componente WHERE codreclamacao_fk = :codreclamacao";
        $stmtDeleteComponentes = $conn->prepare($sqlDeleteComponentes);
        $stmtDeleteComponentes->bindParam(':codreclamacao', $codreclamacao);
        $stmtDeleteComponentes->execute();

        $sqlDeleteReclamacao = "DELETE FROM reclamacao WHERE codreclamacao = :codreclamacao";
        $stmtDeleteReclamacao = $conn->prepare($sqlDeleteReclamacao);
        $stmtDeleteReclamacao->bindParam(':codreclamacao', $codreclamacao);
        $stmtDeleteReclamacao->execute();

        $sql = "UPDATE computador SET codsituacao_fk = 1 WHERE codcomputador = :codComputador";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codComputador', $codcomputador);
        $stmt->execute();

        return true;
    }

    public function editReclamacao($codreclamacao, $descricao, $componentesString)
    {
        $conn = $this->connect();
        
        // Lógica para editar a reclamação
        $sqlUpdate = "UPDATE reclamacao SET descricao = :descricao WHERE codreclamacao = :codreclamacao";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':descricao', $descricao);
        $stmtUpdate->bindParam(':codreclamacao', $codreclamacao);
        $stmtUpdate->execute();
    
        // Lógica para editar os componentes associados à reclamação
        $sqlDeleteComponentes = "DELETE FROM reclamacao_componente WHERE codreclamacao_fk = :codreclamacao";
        $stmtDeleteComponentes = $conn->prepare($sqlDeleteComponentes);
        $stmtDeleteComponentes->bindParam(':codreclamacao', $codreclamacao);
        $stmtDeleteComponentes->execute();
    
        if (!empty($componentesString)) {
            $componentes = explode(',', $componentesString);
            $sqlInsertComponentes = "INSERT INTO reclamacao_componente (codreclamacao_fk, codcomponente_fk) VALUES (:codreclamacao, :codcomponente)";
            $stmtInsertComponentes = $conn->prepare($sqlInsertComponentes);
    
            foreach ($componentes as $codcomponente) {
                $stmtInsertComponentes->bindParam(':codreclamacao', $codreclamacao);
                $stmtInsertComponentes->bindParam(':codcomponente', $codcomponente);
                $stmtInsertComponentes->execute();
            }
        }

        return true;
    }

    public function AlterarSituacao($codcomputador, $codlaboratorio, $situacao) 
    {
        if (empty($codcomputador) || empty($codlaboratorio) || empty($situacao)) {
            return "Código do computador, Código do laboratório e Situação são obrigatórios.";
        }

        try {
            $conn = $this->connect();
    
            $query = "UPDATE computador SET codsituacao_fk = :Situacao WHERE codcomputador = :codcomputador AND codlaboratorio_fk = :codlaboratorio";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':Situacao', $situacao, \PDO::PARAM_INT);
            $stmt->bindParam(':codcomputador', $codcomputador, \PDO::PARAM_INT);
            $stmt->bindParam(':codlaboratorio', $codlaboratorio, \PDO::PARAM_INT);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return "Situação do computador atualizada com sucesso.";
            } else {
                return "Não foi possível atualizar a situação do computador.";
            }
        } catch (\PDOException $e) {
            error_log("Erro de PDO: " . $e->getMessage());
            return "Erro de PDO: " . $e->getMessage();
        }
    }
}
