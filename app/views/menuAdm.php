<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - ADM</title>
    <link rel="stylesheet" href="config/css/menuAdm.css">
    <link rel="stylesheet" href="config/css/cabecario.css">
    <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
    <body>
        <?php
            include("cabecario.php");
        ?>

        <div class="titulo">
            <h1>Central de Manutenção</h1>
        </div>

        <?php foreach($buscarLab as $laboratorio): ?>
            <div class="accordion" style="margin: 40px;" id="accordionLab<?php echo $laboratorio['codlaboratorio']; ?>">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingLab<?php echo $laboratorio['codlaboratorio']; ?>">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLab<?php echo $laboratorio['codlaboratorio']; ?>" aria-expanded="false" aria-controls="collapseLab<?php echo $laboratorio['codlaboratorio']; ?>">
                            <img src="config/images/pc-lab.webp" alt="">
                            <p id="nome-lab" style="text-align: center;"><?php echo $laboratorio['numerolaboratorio']; ?></p>
                        </button>
                    </h2>
                    <div id="collapseLab<?php echo $laboratorio['codlaboratorio']; ?>" class="accordion-collapse collapse" aria-labelledby="headingLab<?php echo $laboratorio['codlaboratorio']; ?>" data-bs-parent="#accordionLab<?php echo $laboratorio['codlaboratorio']; ?>">
                        <div class="accordion-body">
                            <!-- Conteúdo do laboratório -->
                            <?php
                                // Inicia a primeira linha
                                echo "<div class='row'>";
                                $contador = 0; // Inicializa o contador
                                $linha = 1; // Inicializa o número da linha

                                foreach ($laboratorio['computadores'] as $pc) {
                                    if ($contador == 0) {
                                        // Exibe a div com o número da linha quando o contador for zero
                                        echo "<div class='linha'>Fileira " . $linha . "</div>";
                                        $linha++;
                                    }

                                    // Lógica para definir a cor com base na situação do computador
                                    $cor = '';
                                    switch ($pc['codsituacao_fk']) {
                                        case 1:
                                            $cor = "background-color: #228B22;"; // Disponível (verde)
                                            break;
                                        case 2:
                                            $cor = "background-color: #FFFF33;"; // Manutenção (amarelo)
                                            break;
                                        case 3:
                                            $cor = "background-color: #B22222;"; // Indisponível (vermelho)
                                            break;
                                    }

                                    // Exibe o computador com a cor definida
                                    echo "<div class='col-lg-1 col-6'>";
                                    echo "<a href='#' style='text-decoration: none;'>";
                                    echo "<div class='p-2 d-flex justify-content-center mx-2' style='text-align: center; color: black; font-weight: 600; font-size: 24px; width: 80px; height: 80px; border-radius: 5px; $cor'>" . $pc['patrimonio'] . "</div>";
                                    echo "</a>";
                                    echo "</div>";

                                    // Incrementa o contador
                                    $contador++;

                                    // Verifica se o contador chegou a 10
                                    if ($contador == 10) {
                                        // Fecha a div da linha atual e inicia uma nova linha
                                        echo "</div><div class='row'>";
                                        $contador = 0; // Zera o contador
                                    }
                                }
                                // Fecha a div da última linha
                                echo "</div>";

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <script src="config/js/alerts.js"></script>
        <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>