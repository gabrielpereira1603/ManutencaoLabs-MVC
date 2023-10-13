<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="unifunec.edu.br">
                <img src="config/images/logo-unifunec.png" alt="Logo" width="250" height="45" class="d-inline-block align-text-top">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse mt-4 mt-lg-0" id="navbarNavDropdown">
                <?php if (empty($_SESSION)): ?>
                    <!-- Se o usuário não está autenticado -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="https://unifunec.edu.br/" target="_blank">O Unifunec</a></li>
                        <li class="nav-item"><a class="nav-link" href="?router=Site/loginAluno">Área do Aluno</a></li>
                        <li class="nav-item"><a class="nav-link" href="?router=Site/loginColaborador">Área do Colaborador</a></li>
                        <li class="nav-item"><a class="nav-link" href="?router=Site/loginAdm">Área do Administrador</a></li>
                    </ul>
                <?php else: ?>
                    <?php if (isset($_SESSION['codnivel_acesso']) && $_SESSION['codnivel_acesso'] == 3): ?>
                        <ul class="navbar-nav ms-auto">
                            
                            <li class="nav-item"><a class="nav-link" href="menu-admin.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Relatórios
                                </a>
                                
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="relatorio-manutencao.php">Relatório De Manutenções</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="relatorio-componente.php">Relatório De Componentes</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Controle De Usuário
                                </a>
                                
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="gerenciar-envio-email.php">Robô E-mail</a></li>
                                    <li><a class="dropdown-item" href="editar-useradmin.php">Alterar Usuário</a></li>
                                    <li><a class="dropdown-item" href="gerenciar-permisao.php">Gerenciar Permissões</a></li>
                                    <li><a class="dropdown-item" href="criar-useradmin.php">Adicionar Novo Usuário</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="criar-useraluno.php">Adicionar Novo Aluno</a></li>
                                    <li><a class="dropdown-item" href="editar-useraluno.php">Alterar Usuário Aluno</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="criar-laboratorio.php">Manutenção De Laboratórios</a></li>
                            <i class="bi bi-person-circle"></i>
                            <li class="nav-item">
                            <form method="post" action="?router=UsuarioController/logout">
                                <button type="submit" class="btn btn-link nav-link sair-button">Sair</button>
                            </form>
                            </li>
                        </ul>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".sair-button").addEventListener("click", function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Deseja sair?',
            text: "Você não poderá reverter esta ação!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, sair!'
        }).then((result) => {
            if (result.isConfirmed) {
                // O usuário confirmou, envie o formulário de logout
                document.querySelector("form").submit();
            }
        });
    });
});

</script>
