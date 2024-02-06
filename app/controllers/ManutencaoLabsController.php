<?php

namespace app\controllers;
use app\models\ManutencaoLabsModel;

class ManutencaoLabsController extends ManutencaoLabsModel
{
    public function getComputadores() {
        if (isset($_GET['codLaboratorio'])) {
            $codLaboratorio = $_GET['codLaboratorio'];

            $manutencaoLabsModel = new ManutencaoLabsModel();
            $computadores = $manutencaoLabsModel->BuscarPc($codLaboratorio);
    
            header('Content-Type: application/json');
            echo  json_encode($computadores);
        }  
    }

    public function alterLabs() {
        session_start();
        $acao = isset($_POST['acao']) ? $_POST['acao'] : '';
        $nomeLaboratorio = isset($_POST['nomeLaboratorio']) ? $_POST['nomeLaboratorio'] : '';
        
        $manutencaoLabsModel = new ManutencaoLabsModel();
    
        if ($acao == 'excluir') {
            $delete = $manutencaoLabsModel->deleteLab($nomeLaboratorio);
            if ($delete) {
                $_SESSION['success_message'] = 'Laboratório excluido com sucesso';
                header("Location: ?router=Site/manutencaoLabs");

            } else {
                $_SESSION['error_message'] = 'Houve um erro ao excluir o Laboratório';
                header("Location: ?router=Site/manutencaoLabs");
            }
            
        } elseif ($acao == 'criar') {
            $adicionar = $manutencaoLabsModel->createLab($nomeLaboratorio);
            if ($adicionar) {
                $_SESSION['success_message'] = 'Laboratório criado com sucesso';
                header("Location: ?router=Site/manutencaoLabs");
            } else {
                $_SESSION['error_message'] = 'Houve um erro ao criar o Laboratório';
                header("Location: ?router=Site/manutencaoLabs");
            }
            
        }
        
    }

    public function alterPc() {
        session_start();
        $acao = isset($_POST['acao']) ? $_POST['acao'] : '';
        $nomeLaboratorio = $_POST['laboratorio'];
        $patrimonio = $_POST['patrimonio'];

        $manutencaoLabsModel = new ManutencaoLabsModel();
        if ($acao == 'excluir') {
            $delete = $manutencaoLabsModel->deletePc($patrimonio, $nomeLaboratorio);
            if ($delete) {
                $_SESSION['success_message'] = 'Computador excluido com sucesso';
                header("Location: ?router=Site/manutencaoLabs");

            } else {
                $_SESSION['error_message'] = 'Houve um erro ao excluir o Computador';
                header("Location: ?router=Site/manutencaoLabs");
            }
            
        } elseif ($acao == 'criar') {
            $adicionar = $manutencaoLabsModel->createPc($patrimonio, $nomeLaboratorio);
            if ($adicionar) {
                $_SESSION['success_message'] = 'Computador criado com sucesso';
                header("Location: ?router=Site/manutencaoLabs");
            } else {
                $_SESSION['error_message'] = 'Houve um erro ao criar o Computador';
                header("Location: ?router=Site/manutencaoLabs");
            }
            
        }
    }

    public function alterComp() {
        session_start();
        $acao = isset($_POST['acao']) ? $_POST['acao'] : '';
        $componente = $_POST['nome-componente'];

        $manutencaoLabsModel = new ManutencaoLabsModel();
        if ($acao == 'excluir') {
            $delete = $manutencaoLabsModel->deleteComp($componente);
            if ($delete) {
                $_SESSION['success_message'] = 'Componente excluido com sucesso';
                header("Location: ?router=Site/manutencaoLabs");

            } else {
                $_SESSION['error_message'] = 'Houve um erro ao excluir o Componente';
                header("Location: ?router=Site/manutencaoLabs");
            }
            
        } elseif ($acao == 'criar') {
            $adicionar = $manutencaoLabsModel->createComp($componente);
            if ($adicionar) {
                $_SESSION['success_message'] = 'Componente criado com sucesso';
                header("Location: ?router=Site/manutencaoLabs");
            } else {
                $_SESSION['error_message'] = 'Houve um erro ao criar o Componente';
                header("Location: ?router=Site/manutencaoLabs");
            }
            
        }
    }
    
}