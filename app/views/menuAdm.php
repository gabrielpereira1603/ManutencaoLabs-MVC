<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - ADM</title>
    <link rel="stylesheet" href="config/css/home.css">
    <link rel="stylesheet" href="config/css/cabecario.css">
    <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
    <body>
        <?php
            include("cabecario.php");
            var_dump($_SESSION);
            echo ("estremote-bixinha");

            if ($_SESSION['codnivel_acesso'] = 3) {
                echo"deucerto";
            }
        ?>

        <div class="titulo">
            <h1>Central de Manutenção</h1>
        </div>

        <?php if (!empty($laboratorios)): ?>
            <?php foreach ($laboratorios as $laboratorio): ?>
                <div class="accordion" style="margin: 40px;" id="accordionLab<?= $laboratorio['codlaboratorio'] ?>">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingLab<?= $laboratorio['codlaboratorio'] ?>">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLab<?= $laboratorio['codlaboratorio'] ?>" aria-expanded="false" aria-controls="collapseLab<?= $laboratorio['codlaboratorio'] ?>">
                                <img src="assets/img/pc-lab.webp" alt="">
                                <p id="nome-lab" style="text-align: center;"><?= $laboratorio['numerolaboratorio'] ?></p>
                            </button>
                        </h2>
                        <div id="collapseLab<?= $laboratorio['codlaboratorio'] ?>" class="accordion-collapse collapse" aria-labelledby="headingLab<?= $laboratorio['codlaboratorio'] ?>" data-bs-parent="#accordionLab<?= $laboratorio['codlaboratorio'] ?>">
                            <div class="accordion-body">
                                <!-- Conteúdo do acordeão aqui, por exemplo, informações sobre os computadores -->
                                <?php
                                // Aqui você pode adicionar código para exibir informações sobre os computadores deste laboratório
                                // Certifique-se de que você tem acesso às informações dos computadores relacionados a este laboratório
                                // Você pode usar outro loop (por exemplo, foreach) para exibir os computadores
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; font-size: 25px; padding-top: 50px;">Não há Laboratórios Registrados!</p>
            <p style="text-align: center; font-size: 20px; padding-top: 10px;">Para Inserir um Laboratório, basta ir em Manutenção de Laboratórios!</p>
        <?php endif; ?>

        <script src="config/js/alerts.js"></script>
        <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>