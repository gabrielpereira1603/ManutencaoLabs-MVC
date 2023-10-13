<?php

namespace app\controllers;

class Site
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

    public function menuAdm() 
    {
        session_start();
        // Verifique se o usuário está autenticado como administrador
        if (!isset($_SESSION['autenticado_admin']) || $_SESSION['autenticado_admin'] !== true) {
            $_SESSION['error_admin'] = 'Voçê não tem permissão para acessar!';            // O usuário não tem permissão para acessar esta página, redirecione-o para a página de login de aluno
            header("Location:?router=Site/loginAdm");
            exit();
        }
        
        $_SESSION['sucesso_admin'] = 'Bem Vindo!';
        // O usuário está autenticado como administrador, permita o acesso à página menuAdm
        require_once __DIR__ . '/../views/menuAdm.php';
    }
}