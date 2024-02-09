<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="config/images/logo-five_icon.png" type="image/x-icon">
        <title>Manutenção de Laboratórios</title>
        <link rel="stylesheet" href="config/css/manutencaoLabs.css">
        <link rel="stylesheet" href="config/css/cabecario.css">
        <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="config/js/alerts.js"></script>
    </head>
    <body>
        <?php
            include("cabecario.php");
            include("app/messages/error_message.php");
            include("app/messages/success_message.php");
        ?>

        <div class="text">
            <h1>Manutenção Laboratório </h1>
        </div>

        <div class="manutencao-labs">
            <form action="?router=ManutencaoLabsController/alterLabs" method="POST" class="form-group" id="form-manutencao">
                <fieldset>
                    <legend>Inserir/Excluir Laboratório</legend>
                    <select class="form-select" aria-label="Default select example" id="nomelaboratorio" name="laboratorio">
                        <option value="">Selecione um Laboratório</option>
                        <?php foreach($buscarLab as $labs): ?>
                            <option value="<?php echo $labs['codlaboratorio']; ?>">
                                <?php echo $labs['numerolaboratorio']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nomeLaboratorio" name="nomeLaboratorio" placeholder="Selecione o Nome do Laboratorio" required>
                        <label for="nomeLaboratorio">Selecione o Nome do Laboratório</label>
                    </div>
                </fieldset>
                <input type="hidden" name="acao" id="acao-labs" value="">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-danger" type="submit" onclick="setAcaoLab('excluir')">Excluir Laboratório</button>
                    <button class="btn btn-primary" type="submit" onclick="setAcaoLab('criar')">Criar Laboratório</button>
                </div>
            </form>

            <form action="?router=ManutencaoLabsController/alterPc" method="POST" class="form-group">
                <fieldset>
                    <legend>Inserir/Excluir Computador</legend>
                        <select class="form-select" id="laboratorio" aria-label="Default select example" name="laboratorio">
                        <option value="">Selecione um laboratório</option>
                        <?php foreach($buscarLab as $laboratorio): ?>
                            <option value="<?php echo $laboratorio['codlaboratorio']; ?>"><?php echo $laboratorio['numerolaboratorio']; ?></option>
                        <?php endforeach; ?>
                        </select>

                        <select class="form-select" id="computador" aria-label="Default select example" name="computador">
                            <option value="">Selecione um laboratório primeiro</option>
                        </select>

                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <input type="range" min="0" max="500" class="form-range" id="rangeInput">
                            </div>
                            <div class="col-md-4 mb-4">
                                <input type="text" class="form-control" name="quantidade-pc" id="patrimonio" placeholder="Quantidade de Computadores" require>
                            </div>
                        </div>


                        <input type="hidden" name="acao" id="acao-pc" value="">
                </fieldset>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    
                    <button class="btn btn-danger" type="submit" onclick="setAcaoPc('excluir')">Excluir Computador</button>
                    <button class="btn btn-primary" type="submit" onclick="setAcaoPc('criar')">Criar Computador</button>
                </div>
            </form>


            <form action="?router=ManutencaoLabsController/alterComp" method="POST" class="form-group">
                <fieldset>
                    <legend>Inserir Novos Componentes</legend>
                    <select class="form-select" aria-label="Default select example" name="componente-existente" id="select-componente">
                        <option value="">Selecione um componente</option>
                        <?php foreach ($buscarComponentes as $componentes): ?>
                            <option value="<?php echo $componentes['codcomponente']; ?>"><?php echo $componentes['nome_componente']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="form-floating mb-3" id="inputs-componentes">
                        <input type="text" class="form-control" id="nome-componente" name="nome-componente" placeholder="Nome Componente" required>
                        <label for="floatingInput">Nome Componente</label>
                    </div>
                    <input type="hidden" name="acao" id="acao-comp" value="">
                </fieldset>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-danger" type="submit" onclick="setAcao('excluir')">Excluir Componente</button>
                    <button class="btn btn-primary" type="submit" onclick="setAcao('criar')">Criar Componente</button>
                </div>
            </form>

        </div>
        <script src="config/js/manutencaoLabs/formLaboratorio.js"></script>
        <script src="config/js/manutencaoLabs/formComputador.js"></script>
        <script src="config/js/manutencaoLabs/formComponente.js"></script>
        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>