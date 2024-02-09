<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manutenção Labs - ADM</title>
        <link rel="stylesheet" href="config/css/style.css">
        <link rel="shortcut icon" href="config/images/logo-five_icon.png" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>

    <body style="background-color: hsl(0, 0%, 96%)">
        <?php
            include("app/messages/error_message.php");
            include("app/messages/success_message.php");
        ?>

        <section class="login mt-5">
            <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
                <div class="container">
                    <div class="row gx-lg-5 align-items-center">
                        <div class="col-lg-6 mb-5 mb-lg-0">
                            <h1 class="my-5 display-3 fw-bold ls-tight">
                                Wolf <span style="color: #FE8A00;">ERP</span><br>
                                the best<br/>
                                <span style="color: #FE8A00;">for your business</span>
                            </h1>
                            <p style="color: hsl(217, 10%, 50.8%)">
                            Bem-vindo ao Sistema de Manutenções Integrado (SMI), 
                            a solução completa para gerenciar e controlar o andamento dos serviços em seus laboratórios.
                            O SMI oferece uma plataforma centralizada que permite monitorar e supervisionar todas as atividades de manutenção em um único lugar.
                            </p>
                        </div>

                        <div class="col-lg-6 mb-5 mb-lg-0">
                            <div class="card">
                                <div class="card-body py-5 px-md-5">
                                    <form action="?router=UsuarioController/login" method="POST">
                                        <div class="form-outline mb-4">
                                            <input type="text" id="form3Example3" class="form-control" name="login" />
                                            <label class="form-label" name="login" id="login" for="form3Example3">Login</label>
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-outline mb-4">
                                            <input type="password" id="form3Example4" class="form-control" name="senha-adm" />
                                            <label class="form-label" name="senha-adm" id="senha-adm" for="form3Example4">Password</label>
                                        </div>

                                        <!-- Submit button -->
                                        <button type="submit" class="btn btn-block mb-4" style="background-color: #FE8A00;">
                                            Sign up
                                        </button>

                                        <div class="novo-user" style='display: flex; justify-content: center; gap: 50px;'>
                                            <p><a href="#" onclick="showSweetAlert()" style='color: #FE8A00;'><i class="bi bi-info-circle-fill"></i> Problema com a senha?</a></p>

                                            <p><a href="#" id="esqueceu-senha-button" style='color: #FE8A00;'><i class="bi bi-envelope-at"></i> Esqueceu a senha?</a></p>
                                        </div>
                                        <!-- Register buttons -->
                                        <div class="text-center">
                                           

                                            <button type="button" class="btn btn-link btn-floating mx-1">
                                                <i class="fab fa-twitter"></i>
                                            </button>

                                            <button type="button" class="btn btn-link btn-floating mx-1">
                                                <i class="fab fa-github"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="config/js/jquery.min.js"></script>
        <script src="config/js/popper.js"></script>
        <script src="config/js/bootstrap.min.js"></script>
        <script src="config/js/main.js"></script>
        <script src="config/js/login/redefinirSenha.js"></script>
        <script src="config/js/login/problemaSenha.js"></script>
    </body>
</html>