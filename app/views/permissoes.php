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
                <legend>Permissões de usuário</legend>
                <label for="nivel_acesso">Usuários:</label>
                <select class="form-select" aria-label="Default select example" name="usuario" id="select-usuario">
                    <option value="">Selecione um Usuário</option>
                    <?php foreach ($buscarUsuario as $usuario): ?>
                        <option value="<?php echo $usuario['codusuario']; ?>"><?php echo $usuario['nome_usuario']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="nivel_acesso">Selecione o nível de acesso:</label>
                <select class="form-select mb-3" aria-label="Default select example" name="nivel-acesso" id="select-acesso">
                    <option value="">Selecione um acesso</option>
                    <?php foreach ($nivelAcesso as $acesso): ?>
                        <option value="<?php echo $acesso['codnivel_acesso']; ?>"><?php echo $acesso['tipo_acesso']; ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="login-user" name="login" placeholder="RM do usuário">
                    <label for="RM" name="login">Login:</label>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-danger" type="submit" name="remover" >Alterar permissão</button>
                </div>
                
            </div>

            <div class="table-permissao">
                <table class="table table-striped table-hover" >
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">RM</th>
                            <th scope="col">Nome</th>
                        </tr>
                        </thead>
                    <tbody>
                        <legend>Lista de usuários sem permissão:</legend>
                        <?php foreach ($semPermissao as $permissao): ?>
                            <tr>
                                <td><?php echo $permissao['login']?></td>
                                <td><?php echo $permissao['nome_usuario']?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </form>

        <script>
            document.getElementById("select-usuario").addEventListener("change", function () {
                var selectedUsuario = this.value;
                var selectedAcesso = document.getElementById("select-acesso").value;

                if(selectedUsuario === "") {
                    document.getElementById("login-user").value = "";
                    document.getElementById("select-acesso").value = "";
                }else {
                    fetch('?router=UsuarioController/getLogin&codUsuario=' + selectedUsuario)
                    .then(response => response.json())
                    .then(jsonResponse => {
                        // Verifica se o login está definido no objeto antes de atribuir ao campo
                        if (jsonResponse[0].login !== undefined) {
                            document.getElementById("login-user").value = jsonResponse[0].login;
                        }
                    });
                }
            });
        </script>
        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>