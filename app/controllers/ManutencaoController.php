<?php

namespace app\controllers;

use app\models\ManutencaoModel;

class ManutencaoController extends ManutencaoModel
{
    public function concluirManutencao()
    {
        try {
            session_start();
            $codLaboratorio = $_POST['codlaboratorio'];
            $codComputador = $_POST['codcomputador'];
            $nomeUsuario = $_POST['nomeadmin'];
            $codUsuario = $_POST['codusuario'];
            $codReclamacao = $_POST['codreclamacao'];
            $descricaoManutencao = $_POST['descricao_manutencao'];

            $reclamacaoModel = new ManutencaoModel();
            $success = $reclamacaoModel->finalizarManutencao(
                $codLaboratorio,
                $codComputador,
                $nomeUsuario,
                $codUsuario,
                $codReclamacao,
                $descricaoManutencao
            );
            
            if ($success) {
                $_SESSION['success_message'] = 'Manutenção enviada com sucesso!';
                header("Location: ?router=Site/menu");
            } else {
                $_SESSION['error_message'] = 'Houve um erro ao enviar a Manutenção.';
                // Redirecione o usuário para uma página de erro
            }
        } catch (\Exception $e) {
            echo 'Erro: ' . $e->getMessage();
        }
    }
}
