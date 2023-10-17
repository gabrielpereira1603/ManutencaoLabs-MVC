<?php

namespace app\models;

class ReclamacaoModel extends Connection
{
    public function inserirReclamacao($codComputador, $patrimonio, $codLaboratorio, $reclamacao, $componentesSelecionados) {
        $conn = $this->connect();
    
        // Recupere o código do usuário a partir da sessão
        $nomeAluno = $_SESSION['nomeadmin'];
        $codUsuario = $_SESSION['codusuario'];
    
        // Verifique se o computador pertence ao laboratório correto
        $sql = "SELECT codlaboratorio_fk FROM computador WHERE patrimonio = :patrimonio AND codlaboratorio_fk = :codLaboratorio";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':patrimonio', $patrimonio);
        $stmt->bindParam(':codLaboratorio', $codLaboratorio);
        $stmt->execute();
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        if (!$row) {
            return false; // O computador não pertence ao laboratório selecionado
        }
    
        // Inserir a reclamação
        $sql = "INSERT INTO reclamacao (descricao, status, datahora_reclamacao, codcomputador_fk, codlaboratorio_fk, codusuario_fk) VALUES (:reclamacao, 'aberta', NOW(), :codComputador, :codLaboratorio, :codUsuario)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':reclamacao', $reclamacao);
        $stmt->bindParam(':codComputador', $codComputador);
        $stmt->bindParam(':codLaboratorio', $codLaboratorio);
        $stmt->bindParam(':codUsuario', $codUsuario);
        $stmt->execute();
        
        // Obter o ID da reclamação recém-inserida
        $codReclamacao = $conn->lastInsertId();
    
        // Atualizar a situação do computador para "em manutenção"
        $sql = "UPDATE computador SET codsituacao_fk = 2 WHERE codcomputador = :codComputador";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codComputador', $codComputador);
        $stmt->execute();
    
        // Inserir os componentes selecionados na tabela "reclamacao_componente"
        foreach ($componentesSelecionados as $componente) {
            $sql = "INSERT INTO reclamacao_componente (codreclamacao_fk, codcomponente_fk) VALUES (:codReclamacao, :codComponente)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':codReclamacao', $codReclamacao);
            $stmt->bindParam(':codComponente', $componente, \PDO::PARAM_INT); // Defina o tipo de dado como INT
            $stmt->execute();
        }
    
        return true; // Indica sucesso
    }
    
}