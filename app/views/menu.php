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
            var_dump($_SESSION);
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

                                        // Verifique o nível de acesso do usuário
                                    if ($_SESSION['codnivel_acesso'] == 1 && $pc['codsituacao_fk'] > 1) {
                                        // Usuário com nível de acesso 3, defina um estilo para desativar o clique e tornar meio opaco
                                        $styles = 'pointer-events: none; opacity: 0.5;';
                                    } else {
                                        // Usuário com outros níveis de acesso
                                        $styles = ''; // Não desabilite o clique e não altere a opacidade
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
                                    
                                    // Exibe o computador com a cor e estilos definidos
                                    ?>
                                        <div class='col-lg-1 col-6'>
                                            <form method="post" action="?router=Site/EnviarReclamacao">
                                                <input type="hidden" name="codlaboratorio" value="<?php echo $pc['codlaboratorio_fk']; ?>">
                                                <input type="hidden" name="situacao" value="<?php echo $pc['codsituacao_fk']; ?>">
                                                <input type="hidden" name="patrimonio" value="<?php echo $pc['patrimonio']; ?>">
                                                <input type="hidden" name="codcomputador" value="<?php echo $pc['codcomputador']; ?>">
                                                <input type="hidden" name="numerolaboratorio" value="<?php echo $pc['numerolaboratorio']; ?>">
                                                <button type="submit" class="computador-button">
                                                    <div id="pcs" style='display: flex; align-items: center; justify-content: center; text-align: center; color: black; font-weight: 600; font-size: 24px; width: 80px; height: 80px; <?php echo $cor . ' ' . $styles; ?>'>
                                                        <p id="pcs-p"><?php echo $pc['patrimonio']; ?></p>
                                                    </div>
                                                </button>
                                            </form>
                                        </div>
                                    <?php
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