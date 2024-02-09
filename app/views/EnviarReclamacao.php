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
            if (isset($detalhesReclmacoes[0]['codreclamacao'])) {
                $codReclamacao = $detalhesReclmacoes[0]['codreclamacao'];
            } else {
                $codReclamacao = null; // Ou defina um valor padrão se necessário
            }      

            if (isset($detalhesReclamacoes[0]['situacao'])) {
                $situacaoDoComputador = $detalhesReclamacoes[0]['situacao'];
            } else {
                $situacaoDoComputador = null; // Ou defina um valor padrão se necessário
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
                            <?php if ($situacao == 1): ?>
                                <div id="select-pc" style="font-size: 20px; font-weight: 700; border: solid 1.5px black; background-color: green;">
                                    <?php echo $patrimonio; ?>
                                </div>
                            <?php elseif ($situacao == 2): ?>
                                <div id="select-pc" style="font-size: 20px; font-weight: 700; border: solid 1.5px black; background-color: yellow;">
                                    <?php echo $patrimonio; ?>
                                </div>
                            <?php elseif ($situacao == 3): ?>
                                <div id="select-pc" style="font-size: 20px; font-weight: 700; border: solid 1.5px black; background-color: red;">
                                    <?php echo $patrimonio; ?>
                                </div>
                            <?php endif; ?>

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
                                <?php if ($situacao == 1): ?>
                                    <div id="select-pc" style="font-size: 20px; font-weight: 700; border: solid 1.5px black; background-color: green;">
                                        <?php echo $patrimonio; ?>
                                    </div>
                                <?php elseif ($situacao == 2): ?>
                                    <div id="select-pc" style="font-size: 20px; font-weight: 700; border: solid 1.5px black; background-color: red;">
                                        <?php echo $patrimonio; ?>
                                    </div>
                                <?php elseif ($situacao == 3): ?>
                                    <div id="select-pc" style="font-size: 20px; font-weight: 700; border: solid 1.5px black; background-color: yellow;">
                                        <?php echo $patrimonio; ?>
                                    </div>
                                <?php endif; ?>

                                <form action="?router=ManutencaoController/concluirManutencao" method="POST">
                                    <input type="hidden" name="codlaboratorio" value="<?php echo $codLaboratorio?>">
                                    <input type="hidden" name="codcomputador" value="<?php echo $codComputador?>">
                                    <input type="hidden" name="nomeadmin" value="<?php echo $_SESSION['nomeadmin'];?>">
                                    <input type="hidden" name="codusuario" value="<?php echo $_SESSION['codusuario'];?>">
                                    <input type="hidden" name="codreclamacao" value="<?php echo $codReclamacao;?>">

                                    <div class="form-floating" id="descricao-manutencao">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px; margin-bottom: 20px;" name="descricao_manutencao" disable></textarea>
                                        <label for="floatingTextarea2">Descrição Da Manutenção:</label>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Usuario</th>
                                                    <th>RM</th>
                                                    <th>Reclamação</th>
                                                    <th>Laboratório</th>
                                                    <th>Computador</th>
                                                    <th>Situação</th>
                                                    <th>Descrição</th>
                                                    <th>Componentes</th>
                                                    <th>Data/Hora</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($detalhesReclmacoes as $row): ?>
                                                    <tr>
                                                        <td><?php echo $row["nome_usuario"]; ?></td>
                                                        <td><?php echo $row["login"]; ?></td>
                                                        <td><?php echo $row["codreclamacao"]; ?></td>
                                                        <td><?php echo $row["numerolaboratorio"]; ?></td>
                                                        <td><?php echo $row["patrimonio"]; ?></td>
                                                        <td><?php echo $row["situacao"]; ?></td>
                                                        <td><?php echo $row["descricao_reclamacao"]; ?></td>
                                                        <td><?php echo $row["componentes"]; ?></td>
                                                        <td><?php echo date("d/m/Y H:i:s", strtotime($row["datahora_reclamacao"])); ?></td>
                                                    </tr>
                                                    <hr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <hr>
                                    </div>

                                    <?php if (!empty($detalhesReclmacoes)): ?>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="submit" class="btn btn-primary">Concluir Manutenção</button>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                                            <button type="button" class="btn btn-primary" disabled>Concluir Manutenção</button>
                                        </div>
                                    <?php endif; ?>
                                </form>

                                <form action="?router=ReclamacaoController/alterSituacao" method="POST">
                                    <input type="hidden" name="codlaboratorio" value="<?php echo $codLaboratorio?>">
                                    <input type="hidden" name="codcomputador" value="<?php echo $codComputador?>">
                                    <select class="form-select" aria-label="Default select example" id="situacao" name="situacao">
                                        <option value="">Alterar a situação do computador</option>
                                        <?php foreach($buscarSituacao as $situacao): ?>
                                            <option value="<?php echo $situacao['codsituacao']; ?>">
                                                <?php echo $situacao['tiposituacao']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">Editar Situação</button>
                                    </div
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
