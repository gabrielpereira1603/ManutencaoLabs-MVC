<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar User</title>
    <link rel="stylesheet" href="config/css/addUsuario.css">
    <link rel="stylesheet" href="config/css/cabecario.css">
    <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="config/js/alerts.js"></script>
</head>
    <body>
        <?php
            include("cabecario.php");
        ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <script>
                    showErrorAlert('<?php echo $_SESSION['error_message']; ?>');
                </script>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success_message'])): ?>
                <script>
                    showSucessoAlert('<?php echo $_SESSION['success_message']; ?>');
                </script>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

        <div class="titulo">
            <h1>Registrar Novo Usuário</h1>
        </div>

        <div id="loading-indicator" style="display: none;">
            <p>Enviando email...</p>
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </div>


        <form action="?router=UsuarioController/CriarNovoUsuario" method="POST" class="form-group">

            <div class="novo-user">

                <div class="title-user">
                    <legend>Criar Novo Usuário:</legend>
                </div>  

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Selecionar nome do Usuário">
                    <label for="nome">Nome:</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Selecionar email do Usuário">
                    <label for="email">Email:</label>
                </div>
                
                <div class="form-floating mb-3">
                    <select class="form-select" name="nivel_acesso" aria-label="Nível de Acesso">
                        <option value="">Selecione o nível de acesso:</option>
                        <?php foreach ($niveisAcesso as $nivel): ?>
                            <option value="<?php echo $nivel['codnivel_acesso']; ?>"><?php echo $nivel['tipo_acesso']; ?></option>
                        <?php endforeach; ?>     
                    </select>
                    <label for="nivel_acesso">Nível de Acesso:</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="login" name="login" placeholder="Selecionar login do Usuario">
                    <label for="login">Login:</label>
                </div>

                <div class="form-floating mb-3 input-container">
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Selecionar Senha do Usuario">
                    <label for="senha">Senha:</label>
                    <button type="button" class="visibility-btn">👁️</button> 
                </div>
            
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit" name="criaruser">Registar Usuário</button>
                </div>
                <hr>
            </div>

            <div class="user-info">
                <div class="title-info">
                    <legend>Informações sobre cadastro de usuário</legend>
                </div>

                <div class="text-info">
                    <legend>Nome:</legend>
                    <p>É necessario que preencha o campo de nome para que tenha o controle de quem realizou cada serviço.</p>
                    
                    <legend>E-mail:</legend>
                    <p> 
                        O E-mail não sera solicitado para que o usuário faça login, porem será utilizado para a redefinição de senha.<br>
                        Certifique-se de cadastrar um e-mail valido e que voçê tenha acesso.
                    </p>

                    <legend>Login e Senha:</legend>
                    <p> 
                        O sistema de login serve para que voçê possa registrar um novo usuário para acessar o sistema.<br>
                        Lembre-se de colocar credenciais de login que você vá se lembrar.<br>
                        Caso você não lembre suas crendenciais sera possivel a solicitacão de redefinição de senha pelo seu e-mail cadastrado.
                    </p>
                </div>
            </div>
        </form>

        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
