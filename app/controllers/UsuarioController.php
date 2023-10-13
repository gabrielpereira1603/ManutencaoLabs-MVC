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
        

        if ($autenticado && $_SESSION['codnivel_acesso'] == 3) {
            $_SESSION['autenticado_admin'] = true;
            header("Location:?router=Site/menuAdm");
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
    
    
    
    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: ?router=Site/loginAdm"); // redireciona para a página de login de aluno
        exit;
    }
}
