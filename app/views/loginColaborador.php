<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção Labs - CTI</title>
    <link rel="shortcut icon" href="config/images/logo-five_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="config/css/cabecario.css">
    <link rel="stylesheet" href="config/css/index.css">
    <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="config/js/alerts.js"></script>
</head>
    <body style="background-color: #d8e0dd;">

        <?php
            session_start();
            include("cabecario.php");  
        ?>

        <?php if (isset($_SESSION['error_admin'])): ?>
        <script>
            showErrorAlert('<?php echo $_SESSION['error_admin']; ?>');
        </script>
        <?php unset($_SESSION['error_admin']); ?>
        <?php endif; ?>

        <section class="container">
            <div id="form-container">
                <form class="formulario" action="?router=UsuarioController/login" method="POST" id="form">
                    <div>
                        <h2>Iniciar Sessão</h2>
                    </div>

                    <div class="login">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Login:</span>
                            <input type="number" class="form-control" name="login" id="login" aria-label="Sizing example input" aria-describedby  ="inputGroup-sizing-sm">
                        </div>

                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Senha:</span>
                            <input type="password" class="form-control" name="senha-adm" id="senha-adm" aria-label="Sizing example input" aria-describedby  ="inputGroup-sizing-sm">
                        </div>

                        <div class="novo-user" style='display: flex; justify-content: center; gap: 50px;'>
                            <p><u><a href="#" onclick="showSweetAlert()">Problema com a senha?</a></u></p>
                            <p><u><a href="#" id="esqueceu-senha-button">Esqueceu a senha?</a></u></p>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary" id="submit-button" type="submit">Entrar</button>
                        </div>
                    </div>

                </form>
                
            </div>
        </section>
        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>