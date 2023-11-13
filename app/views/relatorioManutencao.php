<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Central De Manutenções</title>
        <link rel="shortcut icon" href="config/images/logo-five_icon.png" type="image/x-icon">
        <link rel="stylesheet" href="config/css/relatorioManutencao.css">
        <link rel="stylesheet" href="config/css/cabecario.css">
        <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    </head>
    <body>
        <?php
            include("cabecario.php");
        ?>

        <h1 class="titulo">
            Relatório De Manutenções
        </h1>

        <form action="?router=RelatorioController/relatorioManutencao" method="POST" class="form-group">

            <fieldset>
                <legend>Selecione o Usuário</legend>
                <select class="form-select" aria-label="Default select example" name="usuarioadmin">
                    <option value="-1">Todos os usuários selecionados</option>
                    <?php foreach ($buscarUsuario as $usuario): ?>
                        <option value="<?php echo $usuario['codusuario']; ?>"><?php echo $usuario['nome_usuario']; ?></option>
                    <?php endforeach; ?>
                </select>

            </fieldset>

                
            <!-- Selecione o Laboratório -->
            <fieldset>
                <legend>Selecione o Laboratório</legend>
                <select class="form-select" aria-label="Default select example" name="laboratorio" id="laboratorio">
                    <option value="">Selecione um laboratórios</option>
                    <option value="-1">Todos os laboratórios</option>
                    <?php foreach ($buscarLab as $laboratorio): ?>
                        <option value="<?php echo $laboratorio['codlaboratorio']; ?>"><?php echo $laboratorio['numerolaboratorio']; ?></option>
                    <?php endforeach; ?>
                </select>
            </fieldset>`
            

            <!-- Selecione o Computador -->
            <fieldset>
                <legend>Selecione o Computador</legend>
                <select class="form-select" aria-label="Default select example" name="computador" id="computador">
                    <option value="">Selecione um laboratório primeiro</option>
                </select>
            </fieldset>

            <script>
                document.getElementById("laboratorio").addEventListener("change", function () {
                    var selectedLaboratorio = this.value;

                    if (selectedLaboratorio === "-1") {
                        // Se Todos os laboratórios estão selecionados, carregue todos os computadores
                        fetch('?router=RelatorioController/getAllComputadores')
                        .then(response => response.json())
                        .then(jsonResponse => {
                            var selectComputador = document.getElementById("computador");
                            selectComputador.innerHTML = "<option value='-1' selected>Todos os computadores</option>";
                        });
                    } else {
                        // Caso contrário, carregue os computadores do laboratório selecionado
                        fetch('?router=RelatorioController/getLaboratorio&codLaboratorio=' + selectedLaboratorio)
                        .then(response => response.json())
                        .then(jsonResponse => {
                            var selectComputador = document.getElementById("computador");
                            selectComputador.disabled = false;
                            selectComputador.innerHTML = "<option value='-2'>Todos os computadores desse laboratório</option>";
                            jsonResponse.forEach(function (computador) {
                                var option = document.createElement("option");
                                option.value = computador.codcomputador;
                                option.text = computador.patrimonio;
                                selectComputador.appendChild(option);

                            });
                        });
                    }
                });
            </script>

            <legend>Selecione o Intervalo de Datas</legend>
            <fieldset class="data">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dataInicio">Data de Início:</label>
                            <input type="date" class="form-control" id="dataInicio" name="dataInicio"required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dataFim">Data de Fim:</label>
                            <input type="date" class="form-control" id="dataFim" name="dataFim" required>
                        </div>
                    </div>
                </div>

            </fieldset>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-primary"  style="margin-top: 20px;" type="submit" name="criar">Gerar Relatório</button>
            </div>

        </form>
        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>