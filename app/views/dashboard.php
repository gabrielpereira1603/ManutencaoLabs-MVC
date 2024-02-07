<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="config/images/logo-five_icon.png" type="image/x-icon">
    <title>Manutenção Labs</title>
    <link rel="stylesheet" href="config/css/dashboard.css">
    <link rel="stylesheet" href="config/css/cabecario.css">
    <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php
        include("cabecario.php");
    ?>

    <div class="title-principal">
        <h1>Dashboard Central De Manutenção</h1>
        <p>Aqui voçê pode consultar gráficos personalizados sobre as manutenções dos laboratórios</p>
    </div>

    <div class="reclamacao-comp">
        <legend>Gráfico De Reclamações Por Componentes</legend>
            <?php
            // Utilize os dados diretamente da sua model
            $labels_componentes = [];
            $data_componentes = [];

            foreach ($dashboard_relatorioComp as $row_componentes) {
                $labels_componentes[] = $row_componentes['nome_componente'];
                $data_componentes[] = $row_componentes['total_reclamacoes'];
            }
            ?>

            <!-- HTML do gráfico de reclamações por componentes -->
            <div class="chart-container">
                <canvas id="myChartComponentes"></canvas>
            </div>

            <script>
                var ctx = document.getElementById('myChartComponentes').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($labels_componentes); ?>,
                        datasets: [{
                            label: 'Total de Reclamações por Componente',
                            data: <?php echo json_encode($data_componentes); ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        </div>

        <div class="computadores-laboratorio">

            <h3>Gráfico de Computadores por Laboratório</h3>
            <p>
                Voçê pode conferir os computadores Indisponíveis, Disponíveis e Em Manutenção de cada laboratório.
            </p>

            <?php
            // Arrays para armazenar os rótulos e dados do gráfico
            $labels_laboratorios = array();
            $data_disponiveis = array();
            $data_indisponiveis = array();
            $data_manutencao = array();

            // Processa os resultados da consulta
            foreach ($dashboard_situacao as $row_laboratorios) {
                $labels_laboratorios[] = $row_laboratorios['numerolaboratorio'];
                $data_disponiveis[] = $row_laboratorios['total_disponiveis'];
                $data_indisponiveis[] = $row_laboratorios['total_indisponiveis'];
                $data_manutencao[] = $row_laboratorios['total_manutencao'];
            }
            ?>

            <!-- HTML do gráfico de computadores por laboratório -->
            <div class="chart-container">
                <canvas id="myChartLaboratorios"></canvas>
            </div>
        </div>

        <div class="graficos-circulo">

            <div class="reclamacoes-laboratorio">
                <h3>Gráfico de Reclamações por Laboratório</h3>
                <p>Neste gráfico voçê pode verificar os laboratório que tem mais reclamações.</p>
                <?php
                // Arrays para armazenar os rótulos e dados do gráfico
                $labels_reclamacoes = array();
                $data_reclamacoes = array();
                $colors = array();

                // Definir cores para cada laboratório
                $colorPalette = array('rgba(255, 99, 132, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(255, 205, 86, 0.8)', 'rgba(75, 192, 192, 0.8)', 'rgba(153, 102, 255, 0.8)');

                // Processar os resultados da consulta
                foreach ($dashboard_relatorioLab as $row_reclamacoes) {
                    $labels_reclamacoes[] = $row_reclamacoes['numerolaboratorio'];
                    $data_reclamacoes[] = $row_reclamacoes['total_reclamacoes'];
                    $colors[] = array_shift($colorPalette);
                }
                ?>

                <!-- HTML do gráfico de reclamações por laboratório -->
                <div class="chart-container">
                    <canvas id="myChartReclamacoes"></canvas>
                </div>
            </div>

            <div class="manutencao-user">
            <h3>Gráfico de manutenções</h3>
                <p>Neste gráfico voçê pode verificar os usuários que tem mais manutenções concluídas.</p>

                <?php
                    // Arrays para armazenar os rótulos e dados do gráfico
                    $labels_manutencoes = array();
                    $data_manutencoes = array();
                    $colors_manutencoes = array();

                    // Processa os resultados da consulta
                    foreach ($dashboard_relatorioUser as $rowManutencoes) {
                        $labels_manutencoes[] = $rowManutencoes['nome_usuario'];
                        $data_manutencoes[] = $rowManutencoes['total_manutencoes'];
                        // Gerar uma cor aleatória para cada fatia do gráfico
                        $colors_manutencoes[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                    }
                ?>

                <div class="chart-container">
                    <canvas id="myChartManutencoes"></canvas>
                </div>
            </div>

        </div>

        <script>
            // Gráfico de reclamações por componentes
            var ctxComponentes = document.getElementById('myChartComponentes').getContext('2d');
            var myChartComponentes = new Chart(ctxComponentes, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels_componentes); ?>,
                    datasets: [{
                        label: 'Total de Reclamações',
                        data: <?php echo json_encode($data_componentes); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 1 // Define o incremento dos valores no eixo Y
                        }
                    }
                }
            });

        </script>

        <!-- Gráfico de Computadores por Laboratório -->
        <script>
            var ctxLaboratorios = document.getElementById('myChartLaboratorios').getContext('2d');
            var myChartLaboratorios = new Chart(ctxLaboratorios, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($labels_laboratorios); ?>,
                    datasets: [
                        {
                            label: 'Disponíveis',
                            data: <?php echo json_encode($data_disponiveis); ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Indisponíveis',
                            data: <?php echo json_encode($data_indisponiveis); ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Em Manutenção',
                            data: <?php echo json_encode($data_manutencao); ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 1 // Define o incremento dos valores no eixo Y
                        }
                    }
                }
            });
        </script>

        <!-- Gráfico de Reclamações por Laboratório -->
        <script>
            var ctxReclamacoes = document.getElementById('myChartReclamacoes').getContext('2d');
            var myChartReclamacoes = new Chart(ctxReclamacoes, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($labels_reclamacoes); ?>,
                    datasets: [{
                        data: <?php echo json_encode($data_reclamacoes); ?>,
                        backgroundColor: <?php echo json_encode($colors); ?>,
                        borderColor: 'rgba(255, 255, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        </script>

        <!-- Gráfico de Manutenções por Usuário Admin -->
        <script>
            var ctxManutencoes = document.getElementById('myChartManutencoes').getContext('2d');
            var myChartManutencoes = new Chart(ctxManutencoes, {
                type: 'doughnut',
                data: {
                labels: <?php echo json_encode($labels_manutencoes); ?>,
                datasets: [{
                    data: <?php echo json_encode($data_manutencoes); ?>,
                    backgroundColor: <?php echo json_encode($colors_manutencoes); ?>,
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1
                }]
                },
                options: {
                responsive: true,
                plugins: {
                    legend: {
                    position: 'bottom'
                    }
                }
                }
            });
        </script>
    <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>