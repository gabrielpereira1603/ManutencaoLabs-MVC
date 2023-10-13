<?php

namespace app\models;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class UsuarioModel extends Connection
{
    public function autenticarAdmin($login, $senha)
    {
        if (empty($login) || empty($senha)) {
            $_SESSION['error_admin'] = 'Por favor, preencha todos os campos de login e senha.';
            return false;
        }

        $conn = $this->connect();

        try {
            $stmt = $conn->prepare('SELECT senha, nome_usuario, nivel_acesso_fk FROM usuario WHERE login = :login');

            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }

            $stmt->execute(['login' => $login]);

            if ($stmt->rowCount() == 1) {
                $usuario = $stmt->fetch();

                if (password_verify($senha, $usuario['senha'])) {
                    // Armazene o codnivel_acesso em uma variável de sessão
                    $_SESSION['autenticado_admin'] = true;
                    $_SESSION['nomeadmin'] = $usuario['nome_usuario'];
                    $_SESSION['codnivel_acesso'] = $usuario['nivel_acesso_fk'];
                    return true;
                }
            }

            $_SESSION['error_admin'] = 'Login ou senha incorretos.';
            return false;
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        return false;
    }

    public function enviarEmailRedefinicao($email)
    {
        require 'vendor/autoload.php'; // Ajuste o caminho conforme necessário
        $conexao = $this->connect(); // Conecte ao banco de dados usando o método da classe Connection
    
        // Verifique se o usuário com o email fornecido existe no banco de dados
        $sql = "SELECT login, nome_usuario FROM usuario WHERE email_usuario = :email";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $resultado = $stmt->fetch();
    
        if (!$resultado) {
            // Usuário com o email fornecido não encontrado
            return false;
        }
    
        // Gere um token único
        $token = bin2hex(random_bytes(50));
    
        // Atualize o token no banco de dados
        $sql = "UPDATE usuario SET token = :token, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email_usuario = :email";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        // Lógica para enviar o email usando as configurações de SMTP
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = 'gabrielpereira16032002@gmail.com';  // Seu e-mail do Gmail
        $mail->Password   = 'muvqlnslnpoadruk'; // Sua senha de aplicativo gerada
        $mail->SMTPSecure = 'tls';         
        $mail->Port       = 587;
    
        $mail->setFrom('gabrielpereira16032002@gmail.com', 'Sistema de Troca de Senha'); // Seu e-mail e nome
        $mail->addAddress($email, $resultado['nome_usuario']); // Email do destinatário e nome

        $mail->IsHTML(true);
        $mail->Subject = 'Sistema De Solicitacao De Troca De Senha Unifunec';
        $mail->CharSet = 'UTF-8';
        $mail->Body = '
        <div style="text-align:center; color: #333333; font-family: Arial, sans-serif;">
            <img src="https://i.imgur.com/1WR1Xsi.png" alt="Logo da Empresa" style="width:200px;">
            <h1 style="color: #004085;">Sistema De Solicitação De Troca De Senha Unifunec</h1>
            <p>Seu login é: '.$resultado['login'].'</p>
            <p style="color: #6c757d;">Olá, recebemos uma solicitação para redefinir a sua senha. Se você fez essa solicitação, clique no link abaixo para alterar sua senha:</p>
            <a href="?router=Site/loginAluno'.$token.'" style="background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top:20px;">Alterar Senha</a>
            <br><br>
            <p style="color: #6c757d;">Se você não solicitou a alteração de senha, por favor, ignore este e-mail.</p>
            <hr>
            <small style="color: #6c757d;">Unifunec - Centro Universitário de Santa Fé do Sul<br>Avenida Conselheiro Antônio Prado, 1400 - Jardim das Palmeiras, Santa Fé do Sul - SP, 15775-000<br>Contato: (17) 3641-9000</small>
        </div>';
        $mail->AltBody = 'Olá, recebemos uma solicitação para redefinir a sua senha. Se você fez essa solicitação, clique no link abaixo para alterar sua senha: ?router=Site/loginAluno'.$token.' Se você não solicitou a alteração de senha, por favor, ignore este e-mail. Unifunec - Centro Universitário de Santa Fé do Sul - Avenida Conselheiro Antônio Prado, 1400 - Jardim das Palmeiras, Santa Fé do Sul - SP, 15775-000 - Contato: (17) 3641-9000';

        if (!$mail->send()) {
            // Erro ao enviar o e-mail
            error_log("Erro ao enviar o email: " . $mail->ErrorInfo);
            return false;
        }
        
    
        return true; // Email enviado com sucesso
    }
    


}