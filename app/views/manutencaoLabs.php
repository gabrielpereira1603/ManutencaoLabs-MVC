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


        <div class="text">
            <h1>Manutenção Laboratório </h1>
        </div>

        <div class="manutencao-labs">
            <form action="?router=ManutencaoLabsController/alterLabs" method="POST" class="form-group">
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
                        <input type="text" class="form-control" id="nomeLaboratorio" name="nomeLaboratorio" placeholder="Selecione o Nome do Laboratorio">
                        <label for="nomeLaboratorio">Selecione o Nome do Laboratório</label>
                    </div>

                    <input type="hidden" name="acao" id="acao" value="">
                </fieldset>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-danger" type="submit" onclick="setAcao('excluir')">Excluir Laboratório</button>
                    <button class="btn btn-primary" type="submit" onclick="setAcao('criar')">Criar Laboratório</button>
                </div>
            </form>

            <script>
                document.getElementById('nomelaboratorio').addEventListener("change", function () {
                    var selectedLaboratorio = this.value;
                    if (selectedLaboratorio === "") {
                        // Limpar o campo se "Selecione um Laboratório" for escolhido
                        document.getElementById("nomeLaboratorio").value = "";
                    } else {
                        // Caso contrário, obter e exibir o nome do laboratório
                        var numerolaboratorio = document.querySelector(`option[value="${selectedLaboratorio}"]`).text;
                        document.getElementById("nomeLaboratorio").value = numerolaboratorio;
                    }
                });

                function setAcao(acao) {
                    document.getElementById('acao').value = acao;
                }
            </script>

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

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="patrimonio" name="patrimonio" placeholder="Selecionar patrimonio do Computador">
                            <label for="patrimonio">Patrimonio Do Computador</label>
                        </div>
                    <input type="hidden" name="acao" id="acao-pc" value="">
                </fieldset>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-danger" type="submit" onclick="setAcao('excluir')">Excluir Computador</button>
                    <button class="btn btn-primary" type="submit" onclick="setAcao('criar')">Criar Computador</button>
                </div>
            </form>

            <script>
                document.getElementById("laboratorio").addEventListener("change", function () {
                    var selectedLaboratorio = this.value;

                    // Limpa o valor do campo de entrada quando o laboratório é alterado
                    document.getElementById("patrimonio").value = '';

                    fetch('?router=ManutencaoLabsController/getComputadores&codLaboratorio=' + selectedLaboratorio)
                    .then(response => response.json())
                    .then(jsonResponse => {
                        var selectComputador = document.getElementById("computador");
                        selectComputador.innerHTML = "<option value='-2'>Selecione um Computador</option>";

                        jsonResponse.forEach(function (computador) {
                            var option = document.createElement("option");
                            option.value = computador.codcomputador;
                            option.text = computador.patrimonio;
                            selectComputador.appendChild(option);
                        });

                        // Atualiza o valor do campo de entrada com base no computador selecionado
                        selectComputador.addEventListener("change", function() {
                            var selectedComputador = this.value;
                            var selectedComputerObj = jsonResponse.find(computer => computer.codcomputador == selectedComputador);
                            document.getElementById("patrimonio").value = selectedComputerObj ? selectedComputerObj.patrimonio : '';
                        });
                    });
                });

                function setAcao(acao) {
                    document.getElementById('acao-pc').value = acao;
                }
            </script>

            <form action="?router=ManutencaoLabsController/alterComp" method="POST" class="form-group">
                <fieldset>
                    <legend>Inserir Novos Componentes</legend>
                    <select class="form-select" aria-label="Default select example" name="componente-existente" id="select-componente">
                        <option value="">Selecione um componente</option>
                        <?php foreach ($buscarComponentes as $componentes): ?>
                            <option value="<?php echo $componentes['codcomponente']; ?>"><?php echo $componentes['nome_componente']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nome-componente" name="nome-componente" placeholder="Nome Componente">
                        <label for="floatingInput">Nome Componente</label>
                    </div>
                    <input type="hidden" name="acao" id="acao-comp" value="">
                </fieldset>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-danger" type="submit" onclick="setAcao('excluir')">Excluir Componente</button>
                    <button class="btn btn-primary" type="submit" onclick="setAcao('criar')">Criar Componente</button>
                </div>
            </form>

            <script>
                document.getElementById("select-componente").addEventListener("change", function () {
                    var selectedComponenteCod = this.value;
                    var nomeComponenteInput = document.getElementById("nome-componente");

                    // Limpar o campo se a opção "Selecione um componente" for escolhida
                    if (selectedComponenteCod === '') {
                        nomeComponenteInput.value = '';
                    } else {
                        // Encontrar o componente correspondente pelo codcomponente
                        var selectedComponente = <?php echo json_encode($buscarComponentes); ?>.find(componente => componente.codcomponente == selectedComponenteCod);

                        // Atualiza o valor do campo de entrada com o nome do componente
                        if (selectedComponente) {
                            nomeComponenteInput.value = selectedComponente.nome_componente;
                        } else {
                            nomeComponenteInput.value = ''; // Limpa o campo se nenhum componente for encontrado
                        }
                    }
                });

                function setAcao(acao) {
                    document.getElementById('acao-comp').value = acao;
                }
            </script>
        </div>

        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>