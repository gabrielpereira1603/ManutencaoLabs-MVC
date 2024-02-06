<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central De Manutenções</title>
    <link rel="shortcut icon" href="config/images/logo-five_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="config/css/enviarReclamacao.css">
    <link rel="stylesheet" href="config/css/cabecario.css">
    <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="config/js/alerts.js"></script>
</head>
    <body>
        <?php
            include("cabecario.php");
            $dados = $_SESSION['resultado_reclamacao'];
        ?>

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button show" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        <img src="config/images/pc-lab.webp" alt="" id="img-accordion">
                        <?php foreach ($dados as $dadosLab): ?>
                            <p><?php echo $dadosLab['numerolaboratorio'];?></p>
                        <?php endforeach; ?>
                    </button>
                </h2>
                <?php if (isset($_SESSION['codnivel_acesso']) && $_SESSION['codnivel_acesso'] == 1): ?>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php foreach ($dados as $dadosPatrimonio): ?>
                                <?php if ($dadosPatrimonio['codsituacao'] == 1): ?>
                                    <div id="select-pc" style="font-size: 20px; font-weight: 700; border: solid 1.5px black; background-color: green;">
                                        <?php echo $dadosPatrimonio['patrimonio']; ?>
                                    </div>
                                <?php elseif ($dadosPatrimonio['codsituacao'] == 2): ?>
                                    <div id="select-pc" style="font-size: 20px; font-weight: 700; border: solid 1.5px black; background-color: yellow;">
                                        <?php echo $dadosPatrimonio['patrimonio']; ?>
                                    </div>
                                <?php elseif ($dadosPatrimonio['codsituacao'] == 3): ?>
                                    <div id="select-pc" style="font-size: 20px; font-weight: 700; border: solid 1.5px black; background-color: red;">
                                        <?php echo $dadosPatrimonio['patrimonio']; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <form action="?router=ReclamacaoController/editOrDelete" method="POST">
                                <?php foreach ($dados as $reclamacao): ?>
                                    <div class="ckBox">
                                        <?php foreach ($buscarComponentes as $componente): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="componente[]" value="<?php echo $componente['codcomponente'] ?>" id="<?php echo $componente['codcomponente'] ?>"
                                                    <?php
                                                        // Verifica se o componente está na lista de componentes da model
                                                        if (!empty($reclamacao['componentes']) && in_array($componente['nome_componente'], explode(',', $reclamacao['componentes']))) {
                                                            echo 'checked'; // Marca o checkbox se o componente estiver na lista
                                                        }

                                                    ?>
                                                >
                                                <label class="form-check-label" for="<?php echo $componente['codcomponente'] ?>">
                                                    <?php echo $componente['nome_componente'] ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="text-reclamacao">
                                        <div class="form-floating">
                                            <h6>Descreva o Problema :</h6>
                                            <textarea class="form-control" id="floatingTextarea2" style="height: 100px" name="reclamacao"><?php echo $reclamacao['descricao']; ?></textarea>
                                            <label for="floatingTextarea2"></label>
                                        </div>
                                    </div>

                                    <input type="hidden" name="acao" id="acao" value="">
                                    <input type="hidden" name="codreclamacao" value="<?php echo $reclamacao['codreclamacao']?>">
                                    <input type="hidden" name="codcomputador" value="<?php echo $reclamacao['codcomputador']?>">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary" onclick="setAcao('editar')">Editar reclamação</button>
                                        <button type="submit" class="btn btn-danger" onclick="setAcao('excluir')">Excluir reclamação</button>
                                        <a href="?router=Site/historicoReclamacao" class="btn btn-secondary">Fechar</a>
                                    </div>
                                <?php endforeach; ?>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                        <h1>Sem informações</h1>
                <?php endif; ?>
            </div>
        </div>

        <script>
            function setAcao(acao) {
                document.getElementById('acao').value = acao;
            }
        </script>
        
        <script src="config/js/alerts.js"></script>
        <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
