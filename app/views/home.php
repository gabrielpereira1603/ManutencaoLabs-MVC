<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção Labs</title>
    <link rel="stylesheet" href="config/css/home.css">
    <link rel="stylesheet" href="config/css/cabecario.css">
    <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
    <?php
        include("cabecario.php");
    ?>
    
    <div class="bem-vindos">
        <h2>Central de Manutenções Unifunec</h2>
    </div>

    <div class="row" id="card-nav">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Área do Aluno</h5>
                    <p class="card-text">Para que ele possa realizar reclamações.</p>
                    <a href="?router=Site/loginAluno" class="btn btn-primary">Aluno</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Área do Colaborador</h5>
                    <p class="card-text">Para que ele possa verificar e concluir manutenções.</p>
                    <a href="?router=Site/loginColaborador" class="btn btn-primary">Colaborador</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Área do Administrador</h5>
                    <p class="card-text">Para que ele possa analisar e gerenciar as manutenções.</p>
                    <a href="?router=Site/loginAdm" class="btn btn-primary">Administrador</a>
                </div>
            </div>
        </div>
    </div>


    
    
    <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>