<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Central De Manutenções</title>
        <link rel="shortcut icon" href="config/images/logo-five_icon.png" type="image/x-icon">
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
            $login = $_SESSION['login'];
            $nome = $_SESSION['nomeadmin'];
            $email = $_SESSION['email_usuario'];
            $acesso = $_SESSION['tipo_acesso'];
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
            <h1>Alterar suas credenciais</h1>
        </div>

        <form action="?router=UsuarioController/editUser" method="POST" class="form-group">
            <div class="novo-user">

                <div class="title-user">
                    <legend>Prencha as informações que deseja alterar:</legend>
                </div>  

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="João">
                    <label for="nome">Nome:</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="login" name="login" placeholder="102030">
                    <label for="login">Login:</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="senha" class="form-control" id="senha" name="senha" placeholder="**********">
                    <label for="password">Senha:</label>
                </div>
                
                <!-- <div class="form-floating mb-3">
                    <select class="form-select" name="nivel_acesso" aria-label="Nível de Acesso">
                        <option value="">Selecione o nível de acesso:</option>
                        <?php foreach ($niveisAcesso as $nivel): ?>
                            <option value="<?php echo $nivel['codnivel_acesso']; ?>"><?php echo $nivel['tipo_acesso']; ?></option>
                        <?php endforeach; ?>     
                    </select>
                    <label for="nivel_acesso">Nível de Acesso:</label>
                </div> -->

            
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit" name="criaruser">Registar Usuário</button>
                </div>
                <hr>
            </div>

            <div class="user-info">
                <div class="title-info">
                    <legend>Suas informações de usuário</legend>
                </div>

                <div class="text-info">
                    <div class="row">
                        <div class="col-md-6">
                            <legend>Login:</legend>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInputDisabled" placeholder="name@example.com" disabled>
                                <label for="floatingInputDisabled"><?php echo $login;?></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <legend>Nome:</legend> 
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInputDisabled" placeholder="name@example.com" disabled>
                                <label for="floatingInputDisabled"><?php echo $nome;?></label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <legend>Email:</legend> 
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInputDisabled" placeholder="name@example.com" disabled>
                                <label for="floatingInputDisabled"><?php echo $email;?></label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <legend>Nivel de Acesso:</legend> 
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInputDisabled" placeholder="name@example.com" disabled>
                                <label for="floatingInputDisabled"><?php echo $acesso;?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>



        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>