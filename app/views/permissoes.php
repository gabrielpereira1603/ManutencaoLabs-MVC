<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central De Manutenções</title>
    <link rel="shortcut icon" href="config/images/logo-five_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="config/css/permissoes.css">
    <link rel="stylesheet" href="config/css/cabecario.css">
    <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="config/js/alerts.js"></script>
</head>
    <body>
        <?php
            include("cabecario.php");
            var_dump($_SESSION);
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
            <h1>Gerenciar Permissões</h1>
        </div>

        <form action="?router=UsuarioController/removerAcesso" method="POST" class="form-group">
            <div class="permissao">

                <legend>Gerenciar permissões de usuário</legend>
                <label for="nivel_acesso">Usuários:</label>
                <select class="form-select" aria-label="Default select example" name="usuario" id="select-usuario">
                    <?php foreach ($buscarUsuario as $usuario): ?>
                        <option value="<?php echo $usuario['codusuario']; ?>"><?php echo $usuario['nome_usuario']; ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="input-rm" name="rm" placeholder="RM do usuário">
                    <label for="RM">Login:</label>
                </div> -->

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-danger" type="submit" name="remover" >Remover permissão</button>
                </div>
            </div>

            <div class="table-permissao">
                <legend>Lista de usuários sem permissão:</legend>
            </div>
        </form>

        <!-- Elemento para exibir o valor selecionado -->
        <span id="selected-value"></span>

        <!-- Seu código JavaScript -->
        <script>
            const selectUsuario = document.getElementById('select-usuario');
            const selectedValue = document.getElementById('selected-value');

            selectUsuario.addEventListener('change', function () {
                // Obtenha o valor selecionado no <select>
                const selectedOption = selectUsuario.options[selectUsuario.selectedIndex];
                const codUsuario = selectedOption.value;

                // Exiba o valor selecionado no elemento <span>
                selectedValue.textContent = codUsuario;
            });
        </script>

        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>