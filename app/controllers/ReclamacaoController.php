<?php

namespace app\controllers;

use app\models\ReclamacaoModel;

class ReclamacaoController extends ReclamacaoModel
{
    public function enviarReclamacao() {
        try {
            $codLaboratorio = $_POST['codlaboratorio'];
            $situacao = $_POST['situacao']; 
            $patrimonio = $_POST['patrimonio']; 
            $codComputador = $_POST['codcomputador']; 
            $numeroLaboratorio = $_POST['numerolaboratorio'];
            $reclamacao = $_POST['reclamacao'];
    
            $componentesSelecionados = isset($_POST['componente']) ? $_POST['componente'] : [];
            $componentesString = implode(', ', $componentesSelecionados);

            session_start();
            $codUsuario = $_SESSION['codusuario']; 
    
            $reclamacaoModel = new ReclamacaoModel();
            $success = $reclamacaoModel->inserirReclamacao($codComputador, $patrimonio, $codLaboratorio, $reclamacao, $componentesSelecionados);
    
            if ($success) { 
                $_SESSION['success_message'] = 'Reclamação enviada com sucesso!';
                header("Location: ?router=Site/menu");
            } else {
                $_SESSION['error_message'] = 'Houve um erro ao enviar a reclamação.';
            }
        } catch (\Exception $e) {
            echo 'Erro: ' . $e->getMessage();
        }
    }
    
    public function editarReclamacao() {
        session_start();
        $codreclamacao = $_POST['codreclamacao'];
        $numeroLaboratorio = $_POST['numerolaboratorio'];
        $patrimonio = $_POST['patrimonio'];
        
        $reclamacaoModel = new ReclamacaoModel();
        
        $detalhesReclamacao = $reclamacaoModel->buscarReclamacao($codreclamacao, $numeroLaboratorio, $patrimonio);

        $_SESSION['resultado_reclamacao'] = $detalhesReclamacao;
        header("Location: ?router=Site/editarReclamacao");
    }

    public function editOrDelete() {
        session_start();
        $acao = isset($_POST['acao']) ? $_POST['acao'] : '';
        $codreclamacao = $_POST['codreclamacao'];
        $codcomputador = $_POST['codcomputador'];
        $descricao = isset($_POST['reclamacao']) ? $_POST['reclamacao'] : '';
        $componentesSelecionados = isset($_POST['componente']) ? $_POST['componente'] : [];
        $componentesString = implode(', ', $componentesSelecionados);
        
        $reclamacaoModel = new ReclamacaoModel();

        if ($acao == 'excluir') {
            $delete = $reclamacaoModel->deleteReclamacao($codcomputador, $codreclamacao, $descricao, $componentesString);
            if ($delete) {
                $_SESSION['success_message'] = 'Reclamação excluida com sucesso';
                header("Location: ?router=Site/historicoReclamacao");

            } else {
                $_SESSION['error_message'] = 'Houve um erro ao excluir o Reclamação';
                header("Location: ?router=Site/historicoReclamacao");
            }
            
        } elseif ($acao == 'editar') {
            $edit = $reclamacaoModel->editReclamacao($codreclamacao, $descricao, $componentesString);
            if ($edit) {
                $_SESSION['success_message'] = 'Reclamação editada com sucesso';
                header("Location: ?router=Site/historicoReclamacao");
            } else {
                $_SESSION['error_message'] = 'Houve um erro ao editar o Reclamação';
                header("Location: ?router=Site/historicoReclamacao");
            }
            
        }
    }

}