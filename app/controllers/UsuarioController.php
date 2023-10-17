<?php
namespace app\controllers;

use app\models\UsuarioModel;

class UsuarioController
{
    public function login()
    {
        session_start();
        // Receba as credenciais do formulário
        $login = $_POST['login'];
        $senha = $_POST['senha-adm'];

        // Verifique as credenciais no modelo
        $usuarioModel = new UsuarioModel();
        $autenticado = $usuarioModel->autenticarAdmin($login, $senha);
        

        if ($autenticado) {
            header("Location:?router=Site/menu");
        } else {
            // Defina a mensagem de erro
            $_SESSION['error_admin'] = 'Dados inválidos';
            // Redirecione para a página de login do administrador (loginAdm)
            header("Location:?router=Site/loginAdm");
        }
    }

    public function enviarEmailRedefinicao()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email']; // Receba o email enviado via POST
        
            // Crie uma instância da model de usuário e chame um método para enviar o email
            $usuarioModel = new UsuarioModel();
            $envioBemSucedido = $usuarioModel->enviarEmailRedefinicao($email);
        
            if ($envioBemSucedido) {
                // Resposta JSON de sucesso
                $response = [
                    "success" => true,
                    "mensagem" => "Email enviado com sucesso para $email."
                ];
            } else {
                // Resposta JSON de erro
                $response = [
                    "success" => false,
                    "mensagem" => "Ocorreu um erro ao enviar o email. Tente novamente mais tarde."
                ];
            }
        
            echo json_encode($response);
        }
    }


    
    public function CriarNovoUsuario() {
        session_start();
    
        $login = $_POST['login'];
        $senha = $_POST['senha'];
        $email = $_POST['email'];
        $nome = $_POST['nome'];
        $nivelAcessoSelecionado = $_POST['nivel_acesso'];
    
        $usuarioModel = new UsuarioModel();
    
        try {
            if ($usuarioModel->CriarNovoUsuario($login, $senha, $nome, $email, $nivelAcessoSelecionado)) {
                // Usuário criado com sucesso, redirecione com a mensagem de sucesso
                $_SESSION['success_message'] = 'Usuário criado com sucesso.';
            } else {
                // Trate o caso em que a criação do usuário falhou
                $_SESSION['error_message'] = 'Houve um erro ao criar o usuário.';
            }
            header("Location:?router=Site/addUsuario");
        } catch (\Exception $e) {
            // Se ocorrer um erro
            $_SESSION['error_message'] = 'Houve um erro ao criar o usuário.';
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: ?router=Site/loginAdm"); // redireciona para a página de login de aluno
        exit;
    }
}
