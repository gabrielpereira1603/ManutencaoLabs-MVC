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

        $usuarioModel = new UsuarioModel();
        $autenticado = $usuarioModel->autenticarAdmin($login, $senha);
        

        if ($autenticado) {
            header("Location:?router=Site/menu");
        } else {
            $_SESSION['error_admin'] = 'Dados inválidos';
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
    
    public function CriarNovoUsuario() 
    {
        session_start();
    
        $login = $_POST['login'];
        $senha = $_POST['senha'];
        $email = $_POST['email'];
        $nome = $_POST['nome'];
        $nivelAcessoSelecionado = $_POST['nivel_acesso'];
    
        $usuarioModel = new UsuarioModel();
    
        try {
            if ($usuarioModel->CriarNovoUsuario($login, $senha, $nome, $email, $nivelAcessoSelecionado)) {
                $_SESSION['success_message'] = 'Usuário criado com sucesso.';
            } else {
                $_SESSION['error_message'] = 'Houve um erro ao criar o usuário.';
            }
            header("Location:?router=Site/addUsuario");
        } catch (\Exception $e) {
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

    public function removerAcesso() {
        session_start();
        $codUsuario = $_POST['codusuario'];
        $usuarioModel = new UsuarioModel();
    
        try {
            if ($usuarioModel->removerPermissao($codUsuario)) {
                $_SESSION['success_message'] = 'Permissão removida com sucesso.';
            } else {
                $_SESSION['error_message'] = 'Houve um erro ao remover a permissão.';
            }
        } catch (\Exception $e) {
            // Se ocorrer um erro na model, captura a exceção e armazena a mensagem de erro
            $_SESSION['error_message'] = $e->getMessage();
        }
    
        header("Location:?router=Site/permissoes");
    }
    
    
}
