<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - ADM</title>
    <link rel="stylesheet" href="config/css/enviarReclamacao.css">
    <link rel="stylesheet" href="config/css/cabecario.css">
    <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
    <body>
        <?php
            include("cabecario.php");
        ?>

        <?php
            // Verifique se os dados do formulário foram enviados
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Recupere os dados do formulário
                $codLaboratorio = $_POST['codlaboratorio'];
                $situacao = $_POST['situacao'];
                $patrimonio = $_POST['patrimonio'];
                $codComputador = $_POST['codcomputador'];
                $numeroLaboratorio = $_POST['numerolaboratorio'];

                // Agora você pode usar essas variáveis conforme necessário na sua página "EnviarReclamacao"
                // Por exemplo, você pode exibi-los assim:
                echo "Código do Laboratório: " . $codLaboratorio . "<br>";
                echo "Situação: " . $situacao . "<br>";
                echo "Patrimônio: " . $patrimonio . "<br>";
                echo "Código do Computador: " . $codComputador . "<br>";
                echo "Código do Computador: " . $numeroLaboratorio . "<br>";
                var_dump($_SESSION);
                // Faça o processamento adicional com esses dados, se necessário
            }
        ?>

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button show" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        <img src="config/images/pc-lab.webp" alt="" id="img-accordion">
                        <?php
                            echo "<p> $numeroLaboratorio</p>";
                        ?>
                    </button>
                </h2>
                <?php if (isset($_SESSION['codnivel_acesso']) && $_SESSION['codnivel_acesso'] == 1): ?>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div id="select-pc" style="font-size: 20px; font-weight: 700; border: solid 1.5px black;">
                                <?php echo $patrimonio; ?>
                            </div>
                            <form action="?router=ReclamacaoController/enviarReclamacao" method="POST">
                                <input type="hidden" name="codlaboratorio" value="<?php echo $codLaboratorio?>">
                                <input type="hidden" name="situacao" value="<?php echo $situacao?>">
                                <input type="hidden" name="patrimonio" value="<?php echo $patrimonio;?>">
                                <input type="hidden" name="codcomputador" value="<?php echo $codComputador?>">
                                <input type="hidden" name="numerolaboratorio" value="<?php echo $numeroLaboratorio?>">

                                <div class="ckBox">
                                    <?php foreach ($buscarComponentes as $componente): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="componente[]" value="<?php echo $componente['codcomponente'] ?>" id="<?php echo $componente['codcomponente'] ?>">
                                            <label class="form-check-label" for="<?php echo $componente['codcomponente'] ?>">
                                                <?php echo $componente['nome_componente'] ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="text-reclamacao">
                                    <div class="form-floating">
                                        <h6>Descreva o Problema :</h6>
                                        <textarea class="form-control" id="floatingTextarea2" style="height: 100px" name="reclamacao"></textarea>
                                        <label for="floatingTextarea2"></label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary" >Enviar reclamação</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if (isset($_SESSION['codnivel_acesso']) && $_SESSION['codnivel_acesso'] > 1): ?>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div id="select-pc" style="font-size: 20px; font-weight: 700; border: solid 1.5px black;">
                                    <?php echo $patrimonio; ?>
                                </div>
                                <form action="#" method="POST">
                                
                                    <div class="ckBox">
                                        <?php foreach($buscarComponentes as $componente): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="<?php echo $componente['nome_componente'] ?>" value="<?php echo $componente['nome_componente']?>" id="<?php echo $componente['codcomponente']?>">
                                                <label class="form-check-label" for="<?php echo $componente['codcomponente'] ?>"> 
                                                    <?php echo $componente['nome_componente'] ?> 
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px; margin-bottom: 20px;" name="descricao_manutencao"></textarea>
                                        <label for="floatingTextarea2">Descrição Da Manutenção:</label>
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary" >Concluir Manutenção</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
            

        <script src="config/js/alerts.js"></script>
        <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

<?php

?>