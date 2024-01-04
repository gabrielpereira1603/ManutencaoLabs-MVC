<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Central De Manutenções</title>
        <link rel="shortcut icon" href="config/images/logo-five_icon.png" type="image/x-icon">
        <link rel="stylesheet" href="config/css/relatorioComponente.css">
        <link rel="stylesheet" href="config/css/cabecario.css">
        <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="config/js/alerts.js"></script>
    </head>
    <body>
        <?php
            include("cabecario.php");
            // var_dump($_SESSION);    
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
        <h1 class="titulo">
            Relatório De Manutenções
        </h1>
        

        <form action="?router=RelatorioController/relatorioComponente" method="POST" class="form-group" id="myForm">

            <fieldset>
                <legend>Selecione o Laboratório</legend>
                <select class="form-select" aria-label="Default select example" name="laboratorio" id="laboratorio">
                    <option value="">Selecionar um laboratório</option>
                    <option value="-1">Todos os laboratórios</option>
                    <?php foreach ($buscarLab as $laboratorio): ?>
                        <option value="<?php echo $laboratorio['codlaboratorio']; ?>"><?php echo $laboratorio['numerolaboratorio']; ?></option>
                    <?php endforeach; ?>
                </select>
            </fieldset>

            <legend>Selecione os Componentes</legend>
            <p id="error-message" style="color: red; display: none; width: 100%; background-color: rgba(255, 0, 0, 0.219); border-radius: 10px; padding: 20px; border: solid 1px red;">Por favor, selecione pelo menos um componente antes de gerar o relatório.</p>
            <fieldset id="components-fieldset" class="comp">
                <div class="row justify-content-md-center">
                    <?php foreach ($buscarComponentes as $componentes): ?>
                        <div class="col-6 col-md-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="componente[]" id="<?php echo $componentes['codcomponente']?>" value="<?php echo $componentes['codcomponente']?>">
                                <label class="form-check-label" for="<?php echo $componentes['codcomponente']?>"><?php echo $componentes['nome_componente']?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </fieldset>


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
            <button class="btn btn-primary"  style="margin-top: 10px;" type="submit" name="relatorio-comp">Gerar Relatório</button>
        </div>
    </form>
    <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>