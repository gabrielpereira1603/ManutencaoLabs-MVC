<?php

namespace app\models;

class RelatorioModel extends Connection
{
    public function getComputadores($codLaboratorio) {
        $conn = $this->connect();

        // Realize a consulta SQL para buscar os dados
        $sql = "SELECT * FROM computador WHERE codlaboratorio_fk = :codLaboratorio";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codLaboratorio', $codLaboratorio);
        $stmt->execute();
        $computadores = $stmt->fetchAll();


        return($computadores);
    }

    public function todosPc() {
        $conn = $this->connect();

        $sql = "SELECT * FROM computador";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $computadores = $stmt->fetchAll();

        return($computadores);
    }

    public function Manutencao($usuarioadmin, $codLaboratorio, $codComputador, $dataInicio, $dataFim) {
        $conn = $this->connect();

        if ($codLaboratorio == -1 && $codComputador == -1 && $usuarioadmin == -1) {
            $sql = "SELECT
                manutencao.datahora_manutencao,
                manutencao.descricao_manutencao,
                usuario.nome_usuario,
                usuario.login,
                usuario.nivel_acesso_fk,
                reclamacao.status AS status_reclamacao,
                computador.patrimonio,
                laboratorio.numerolaboratorio,
                reclamacao.descricao AS descricao_reclamacao,
                reclamacao.datahora_reclamacao,
                GROUP_CONCAT(componente.nome_componente) AS componentes
            FROM 
                manutencao
            INNER JOIN usuario ON manutencao.codusuario_fk = usuario.codusuario
            LEFT JOIN reclamacao ON manutencao.codreclamacao_fk = reclamacao.codreclamacao
            LEFT JOIN computador ON reclamacao.codcomputador_fk = computador.codcomputador
            LEFT JOIN laboratorio ON reclamacao.codlaboratorio_fk = laboratorio.codlaboratorio
            LEFT JOIN reclamacao_componente ON reclamacao.codreclamacao = reclamacao_componente.codreclamacao_fk
            LEFT JOIN componente ON reclamacao_componente.codcomponente_fk = componente.codcomponente
            WHERE 
                (manutencao.datahora_manutencao BETWEEN '$dataInicio' AND '$dataFim')
            GROUP BY
                manutencao.codmanutencao";
        } else if ($codLaboratorio == -1 && $codComputador == -1) {
            $sql = "SELECT
                manutencao.datahora_manutencao,
                manutencao.descricao_manutencao,
                usuario.nome_usuario,
                usuario.login,
                usuario.nivel_acesso_fk,
                reclamacao.status AS status_reclamacao,
                computador.patrimonio,
                laboratorio.numerolaboratorio,
                reclamacao.descricao AS descricao_reclamacao,
                reclamacao.datahora_reclamacao,
                GROUP_CONCAT(componente.nome_componente) AS componentes
            FROM 
                manutencao
            INNER JOIN usuario ON manutencao.codusuario_fk = usuario.codusuario
            LEFT JOIN reclamacao ON manutencao.codreclamacao_fk = reclamacao.codreclamacao
            LEFT JOIN computador ON reclamacao.codcomputador_fk = computador.codcomputador
            LEFT JOIN laboratorio ON reclamacao.codlaboratorio_fk = laboratorio.codlaboratorio
            LEFT JOIN reclamacao_componente ON reclamacao.codreclamacao = reclamacao_componente.codreclamacao_fk
            LEFT JOIN componente ON reclamacao_componente.codcomponente_fk = componente.codcomponente
            WHERE 
                (manutencao.datahora_manutencao BETWEEN '$dataInicio' AND '$dataFim')
                AND manutencao.codusuario_fk = $usuarioadmin
            GROUP BY
                manutencao.codmanutencao";
        } else if ($codComputador == -2) {
            $sql = "SELECT
                manutencao.datahora_manutencao,
                manutencao.descricao_manutencao,
                usuario.nome_usuario,
                usuario.login,
                usuario.nivel_acesso_fk,
                reclamacao.status AS status_reclamacao,
                computador.patrimonio,
                laboratorio.numerolaboratorio,
                reclamacao.descricao AS descricao_reclamacao,
                reclamacao.datahora_reclamacao,
                GROUP_CONCAT(componente.nome_componente) AS componentes
            FROM 
                manutencao
            INNER JOIN usuario ON manutencao.codusuario_fk = usuario.codusuario
            LEFT JOIN reclamacao ON manutencao.codreclamacao_fk = reclamacao.codreclamacao
            LEFT JOIN computador ON reclamacao.codcomputador_fk = computador.codcomputador
            LEFT JOIN laboratorio ON reclamacao.codlaboratorio_fk = laboratorio.codlaboratorio
            LEFT JOIN reclamacao_componente ON reclamacao.codreclamacao = reclamacao_componente.codreclamacao_fk
            LEFT JOIN componente ON reclamacao_componente.codcomponente_fk = componente.codcomponente
            WHERE 
                (manutencao.datahora_manutencao BETWEEN '$dataInicio' AND '$dataFim')
                AND manutencao.codusuario_fk = $usuarioadmin
                AND laboratorio.codlaboratorio = $codLaboratorio
            GROUP BY
                manutencao.codmanutencao";
        } else {
            $sql = "SELECT
            manutencao.datahora_manutencao,
            manutencao.descricao_manutencao,
            usuario.nome_usuario,
            usuario.login,
            usuario.nivel_acesso_fk,
            reclamacao.status AS status_reclamacao,
            computador.patrimonio,
            laboratorio.numerolaboratorio,
            reclamacao.descricao AS descricao_reclamacao,
            reclamacao.datahora_reclamacao,
            GROUP_CONCAT(componente.nome_componente) AS componentes
        FROM 
            manutencao
        INNER JOIN usuario ON manutencao.codusuario_fk = usuario.codusuario
        LEFT JOIN reclamacao ON manutencao.codreclamacao_fk = reclamacao.codreclamacao
        LEFT JOIN computador ON reclamacao.codcomputador_fk = computador.codcomputador
        LEFT JOIN laboratorio ON reclamacao.codlaboratorio_fk = laboratorio.codlaboratorio
        LEFT JOIN reclamacao_componente ON reclamacao.codreclamacao = reclamacao_componente.codreclamacao_fk
        LEFT JOIN componente ON reclamacao_componente.codcomponente_fk = componente.codcomponente
        WHERE 
            (manutencao.datahora_manutencao BETWEEN '$dataInicio' AND '$dataFim')
            AND manutencao.codusuario_fk = $usuarioadmin
            AND laboratorio.codlaboratorio = $codLaboratorio
            AND computador.codcomputador = $codComputador
        GROUP BY
            manutencao.codmanutencao";
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
    
        return $resultado;
    }
    
}
