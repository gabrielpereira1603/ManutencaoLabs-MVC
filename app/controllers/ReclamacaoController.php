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
    
            // Recupere os componentes selecionados do formulário e converta em uma string
            $componentesSelecionados = isset($_POST['componente']) ? $_POST['componente'] : [];
            $componentesString = implode(', ', $componentesSelecionados);

    
            session_start();
            $codUsuario = $_SESSION['codusuario']; 
    
            $reclamacaoModel = new ReclamacaoModel();
            $success = $reclamacaoModel->inserirReclamacao($codComputador, $patrimonio, $codLaboratorio, $reclamacao, $componentesSelecionados);
    
            if ($success) { 
                // Redirecione o usuário para uma página de sucesso ou outra página apropriada
                $_SESSION['success_message'] = 'Reclamação enviada com sucesso!';
                header("Location: ?router=Site/menu");
            } else {
                // Trate erros, se houverem
                $_SESSION['error_message'] = 'Houve um erro ao enviar a reclamação.';
                // Redirecione o usuário para uma página de erro
            }
        } catch (\Exception $e) {
            // Em caso de exceção, você pode tratar o erro aqui ou registrar em um arquivo de log
            echo 'Erro: ' . $e->getMessage();
        }
    }
    

}