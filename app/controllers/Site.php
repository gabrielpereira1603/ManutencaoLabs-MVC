<?php

namespace app\controllers;

use app\models\Crud;

class Site extends Crud
{
    public function home() 
    {
        require_once __DIR__ . '/../views/home.php';
    }

    public function redefinirSenha($nova_senha) 
    {
        $new_senha = $nova_senha;   
        require_once __DIR__ . '/../views/redefinirSenha.php';
    }

    public function loginAluno() {
        require_once __DIR__ . '/../views/loginAluno.php';
    }

    public function loginColaborador() {
        require_once __DIR__ . '/../views/loginColaborador.php';
    }

    public function loginAdm() {
        require_once __DIR__ . '/../views/loginAdm.php';
    }

    public function menu() 
    {
        session_start();
        // Verifique se o usuário está autenticado como administrador
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            // O usuário não tem permissão para acessar esta página, redirecione-o para a página de login de aluno
            header("Location:?router=Site/loginAdm");
            exit();
        }
        $buscarLab = $this->buscarLaboratorio();
        // O usuário está autenticado como administrador, permita o acesso à página menuAdm
        require_once __DIR__ . '/../views/menuAdm.php';
    }

    public function addUsuario() {
        session_start();
        // Verifique se o usuário está autenticado como administrador
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            // O usuário não tem permissão para acessar esta página, redirecione-o para a página de login de aluno
            header("Location:?router=Site/loginAdm");
            exit();
        }

        //trazer os niveis de acessos para o select
        $niveisAcesso = $this->getNiveisAcesso();
        require_once __DIR__ . '/../views/addUsuario.php';
    }

    public function EnviarReclamacao() {
        session_start();
        // Verifique se o usuário está autenticado como administrador
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            // O usuário não tem permissão para acessar esta página, redirecione-o para a página de login de aluno
            header("Location:?router=Site/loginAdm");
            exit();  
        }
        // Recupere as informações do computador a partir da solicitação POST
        $codLaboratorio = $_POST['codlaboratorio'];
        $situacao = $_POST['situacao'];
        $patrimonio = $_POST['patrimonio'];
        $codComputador = $_POST['codcomputador'];
        $numeroLaboratorio = $_POST['numerolaboratorio'];

        $buscarComponentes = $this->getComponentes();
        // Carregue a página "EnviarReclamacao" aqui
        require_once __DIR__ . '/../views/EnviarReclamacao.php';
                
    }

}