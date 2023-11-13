<?php

namespace app\models;

class ManutencaoModel extends Connection
{
    public function finalizarManutencao($codLaboratorio, $codComputador, $nomeUsuario, $codUsuario, $codReclamacao, $descricaoManutencao) {
        $conn = $this->connect();

        if (isset($descricaoManutencao)) {
            $sql = "INSERT INTO manutencao(descricao_manutencao, datahora_manutencao, codusuario_fk, codreclamacao_fk) VALUES (:descricaoManutencao, NOW(), :codUsuario, :codReclamacao)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':descricaoManutencao', $descricaoManutencao);
            $stmt->bindParam(':codUsuario', $codUsuario);
            $stmt->bindParam(':codReclamacao', $codReclamacao);
            $stmt->execute();

            // Atualiza o status da reclamação para "concluída"
            $sql_update_status = "UPDATE reclamacao SET status = 'concluída' WHERE codreclamacao = :codReclamacao";
            $stmt_update_status = $conn->prepare($sql_update_status);
            $stmt_update_status->bindParam(':codReclamacao', $codReclamacao);
            $stmt_update_status->execute();

            // Atualiza a situação do computador para o valor desejado (por exemplo, 1)
            $novaSituacao = 1; // Defina o valor desejado
            $sql_update_situacao = "UPDATE computador SET codsituacao_fk = :novaSituacao WHERE codcomputador = :codComputador";
            $stmt_update_situacao = $conn->prepare($sql_update_situacao);
            $stmt_update_situacao->bindParam(':codComputador', $codComputador);
            $stmt_update_situacao->bindParam(':novaSituacao', $novaSituacao);
            $stmt_update_situacao->execute();
            return true; // Indica que a operação foi bem-sucedida
        } else {
            $_SESSION['error_message'] = 'Preencha a descrição da Manutenção.';
        }
    }
}


