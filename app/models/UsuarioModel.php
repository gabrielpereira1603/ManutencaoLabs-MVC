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
            $stmt = $conn->prepare('SELECT 
            usuario.codusuario, 
            usuario.senha, 
            usuario.nome_usuario, 
            usuario.email_usuario, 
            usuario.nivel_acesso_fk, 
            nivel_acesso.tipo_acesso
            FROM 
                usuario 
            INNER JOIN 
                nivel_acesso ON usuario.nivel_acesso_fk = nivel_acesso.codnivel_acesso
            WHERE 
            usuario.login = :login');

            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }

            $stmt->execute(['login' => $login]);

            if ($stmt->rowCount() == 1) {
                $usuario = $stmt->fetch();

                if (password_verify($senha, $usuario['senha'])) {
                    // Armazene o codnivel_acesso em uma variável de sessão
                    $_SESSION['autenticado_admin'] = true;
                    $_SESSION['login'] = $login;
                    $_SESSION['nomeadmin'] = $usuario['nome_usuario'];
                    $_SESSION['email_usuario'] = $usuario['email_usuario'];
                    $_SESSION['codusuario'] = $usuario['codusuario'];
                    $_SESSION['codnivel_acesso'] = $usuario['nivel_acesso_fk'];
                    $_SESSION['tipo_acesso'] = $usuario['tipo_acesso'];
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

    public function CriarNovoUsuario($login, $senha, $nome, $email, $nivelAcessoSelecionado)
    {
        // Verifique se os campos estão preenchidos
        if (empty($login) || empty($senha) || empty($nome) || empty($email)) {
            $_SESSION['error_message'] = 'Todos os campos devem ser preenchidos.';
            return false;
        }
    
        $conn = $this->connect(); // Use a conexão da classe Connection
    
        // Consulta o banco de dados para garantir que o login, nome e email não existam
        $stmt = $conn->prepare('SELECT * FROM usuario WHERE login = :login OR nome_usuario = :nome OR email_usuario = :email');
        $stmt->execute(['login' => $login, 'nome' => $nome, 'email' => $email]);
    
        if ($stmt->rowCount() > 0) {
            $_SESSION['error_message'] = 'O nome de usuário ou login já existe.';
            return false;
        }
    
        // Gere o hash da senha
        $hashed_password = password_hash($senha, PASSWORD_DEFAULT);
    
        if ($hashed_password === false) {
            $_SESSION['error_message'] = 'Falha ao criar hash da senha';
            return false;
        }
    
        // Execute a inserção dos dados no banco de dados
        $stmt = $conn->prepare('INSERT INTO usuario (login, senha, nome_usuario, email_usuario, nivel_acesso_fk) VALUES (:login, :senha, :nome, :email, :nivelAcesso)');
        $result = $stmt->execute([
            ':login' => $login,
            ':senha' => $hashed_password,
            ':nome' => $nome,
            ':email' => $email,
            ':nivelAcesso' => $nivelAcessoSelecionado,
        ]);
    
        if ($result === false) {
            $_SESSION['error_message'] = 'Houve um erro ao registrar o usuário.';
            return false;
        }
    
        $_SESSION['success_message'] = 'Usuário criado com sucesso';

        // // Lógica para enviar o email usando as configurações de SMTP
        // $mail = new PHPMailer;

        // $mail->isSMTP();
        // $mail->Host       = 'smtp.gmail.com';  
        // $mail->SMTPAuth   = true;                                  
        // $mail->Username   = 'gabrielpereira16032002@gmail.com';  // Seu e-mail do Gmail
        // $mail->Password   = 'muvqlnslnpoadruk'; // Sua senha de aplicativo gerada
        // $mail->SMTPSecure = 'tls';         
        // $mail->Port       = 587;
    
        // $mail->setFrom('gabrielpereira16032002@gmail.com', 'Sistema de Manutenção Unifunec'); // Seu e-mail e nome
        // $mail->addAddress($email, $nome); // Email do destinatário e nome

        // $mail->IsHTML(true);
        // $mail->CharSet = 'UTF-8';
        // $mail->Subject = 'Bem-vindo ao Sistema de Manutenção Unifunec';
        // $mail->Body = '
        // <html>
        //     <head>
        //         <style>
        //             div {
        //                 text-align: center;
        //                 color: #333333;
        //                 font-family: Arial, sans-serif;
        //             }
        //             img {
        //                 width: 200px;
        //             }
        //             h1 {
        //                 color: #004085;
        //             }
        //             p {
        //                 color: #6c757d;
        //             }
        //             a {
        //                 background-color: #007bff;
        //                 color: #ffffff;
        //                 padding: 10px 20px;
        //                 text-decoration: none;
        //                 border-radius: 5px;
        //                 margin-top: 20px;
        //             }
        //             small {
        //                 color: #6c757d;
        //             }
        //         </style>
        //     </head>
        //     <body>
        //         <div>
        //             <img src="https://i.imgur.com/1WR1Xsi.png" alt="Logo da Empresa">
        //             <h1>Bem-vindo ao Sistema de Solicitação de Troca de Senha Unifunec</h1>
        //             <p>Seu login é: ' . $login . '</p>
        //             <p>Olá, seja bem-vindo ao nosso sistema. Agradecemos por se juntar a nós. Estamos felizes em tê-lo como nosso usuário.</p>
        //             <p>Se você tiver alguma dúvida ou precisar de assistência, não hesite em entrar em contato conosco.</p>
        //             <hr>
        //             <small>Unifunec - Centro Universitário de Santa Fé do Sul<br>Avenida Conselheiro Antônio Prado, 1400 - Jardim das Palmeiras, Santa Fé do Sul - SP, 15775-000<br>Contato: (17) 3641-9000</small>
        //         </div>
        //     </body>
        // </html>';
        // $mail->AltBody = 'Bem-vindo ao Sistema de Solicitação de Troca de Senha Unifunec' . PHP_EOL . 
        //     'Seu login é: ' . $login . PHP_EOL .
        //     'Olá, seja bem-vindo ao nosso sistema. Agradecemos por se juntar a nós. Estamos felizes em tê-lo como nosso usuário.' . PHP_EOL .
        //     'Se você tiver alguma dúvida ou precisar de assistência, não hesite em entrar em contato conosco.' . PHP_EOL .
        //     'Unifunec - Centro Universitário de Santa Fé do Sul - Avenida Conselheiro Antônio Prado, 1400 - Jardim das Palmeiras, Santa Fé do Sul - SP, 15775-000 - Contato: (17) 3641-9000';

        // if (!$mail->send()) {
        //     // Erro ao enviar o e-mail
        //     error_log("Erro ao enviar o email: " . $mail->ErrorInfo);
        //     return false;
        // }
    
        // return true;
    }

    public function asyncUser($codUsuario) {
        $conn = $this->connect();

        $sql = "SELECT login FROM usuario WHERE codusuario = :codUsuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codUsuario', $codUsuario);
        $stmt->execute();
        $loginUser = $stmt->fetchAll();

        return($loginUser);
    }

    public function removerPermissao($codUsuario, $login, $codAcesso)
    {
        $conn = $this->connect();
    
        $sql = "UPDATE usuario SET nivel_acesso_fk = :codAcesso WHERE codusuario = :codUsuario OR login = :login";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':codAcesso', $codAcesso);
        $stmt->bindParam(':codUsuario', $codUsuario);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
    
        return true;
    }

    public function alterarUsuario($nome_user, $email_user, $login_user) {
        $conn = $this->connect();

    }
}
    
