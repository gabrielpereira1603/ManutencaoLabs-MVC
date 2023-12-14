<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central De Manutenções</title>
    <link rel="shortcut icon" href="config/images/logo-five_icon.png" type="image/x-icon">
    <link rel="stylesheet" href="config/css/resultadoManutencao.css">
    <link rel="stylesheet" href="config/css/cabecario.css">
    <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="config/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="config/js/alerts.js"></script>
</head>
<body>
    <?php
        include("cabecario.php");
    ?>

    <?php
        // Verifique se existem dados na sessão
        if (isset($_SESSION['resultado_componentes'])) {
            $dados = $_SESSION['resultado_componentes'];

            // Verifica se há dados antes de tentar exibir
            if (!empty($dados)) { ?>
            <div class="table-responsive">
                <table id="tabela-manutencao" class="display">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome do Aluno</th>
                            <th>RM do Aluno</th>
                            <th>Data/Hora da Reclamação</th>
                            <th>Número do Laboratório</th>
                            <th>Componentes</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dados as $componente) {
                            echo '
                            <tr>
                                <td>' . $componente['codreclamacao'] . '</td>
                                <td>' . $componente['nome_usuario'] . '</td>
                                <td>' . $componente['login'] . '</td>
                                <td>' . $componente['datahora_reclamacao'] . '</td>
                                <td>' . $componente['numerolaboratorio'] . '</td>
                                <td>' . $componente['componentes'] . '</td>
                                <td>' . $componente['descricao'] . '</td>
                            </tr>';
                        }?>
                    </tbody>
                </table>
                <div class="d-grid gap-2 mt-4">
                    <button id="gerarPDF" class="btn btn-primary" type="button">Gerar Relatório em PDF</button>
                </div>
            </div>
    <?php
            }
        }
    ?>

    <script>
        $(document).ready(function () {
            $("#tabela-manutencao").DataTable();
        });
    </script>
    <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
