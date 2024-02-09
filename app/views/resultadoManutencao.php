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
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    </head>

    <body>
        <?php
        include("cabecario.php");
        ?>

        <?php
        // Verifique se existem dados na sessão
        if (isset($_SESSION['resultado_manutencao'])) {
            $dados = $_SESSION['resultado_manutencao'];

            // Verifica se há dados antes de tentar exibir
            if (!empty($dados)) { ?>
                <div class="table-responsive">
                    <table id="tabela-manutencao" class="display">
                        <thead>
                            <tr>
                                <th>Data/Hora Manutenção</th>
                                <th>Descrição Manutenção</th>
                                <th>Nome Usuário</th>
                                <th>Login</th>
                                <th>Nível de Acesso</th>
                                <th>Status Reclamação</th>
                                <th>Patrimônio Computador</th>
                                <th>Número Laboratório</th>
                                <th>Descrição Reclamação</th>
                                <th>Data/Hora Reclamação</th>
                                <th>Componentes</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($dados as $manutencao) {
                                echo '<tr>
                                    <td>' . $manutencao['datahora_manutencao'] . '</td>
                                    <td>' . $manutencao['descricao_manutencao'] . '</td>
                                    <td>' . $manutencao['nome_usuario'] . '</td>
                                    <td>' . $manutencao['login'] . '</td>
                                    <td>' . $manutencao['nivel_acesso_fk'] . '</td>
                                    <td>' . $manutencao['status_reclamacao'] . '</td>
                                    <td>' . $manutencao['patrimonio'] . '</td>
                                    <td>' . $manutencao['numerolaboratorio'] . '</td>
                                    <td>' . $manutencao['descricao_reclamacao'] . '</td>
                                    <td>' . $manutencao['datahora_reclamacao'] . '</td>
                                    <td>' . $manutencao['componentes'] . '</td>
                                </tr>';
                            } ?>

                        </tbody>
                    </table>
                    <form action="?router=RelatorioController/baixarPDF" method="post">
                        <input type="hidden" name="dados_manutencao" value="<?php echo htmlspecialchars(json_encode($dados)); ?>">

                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-primary" type="button" onclick="gerarPDF()">Gerar Relatório em PDF</button>
                        </div>
                    </form>
                    <?php
                    // var_dump();
                    ?>
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

        <script>
            import { jsPDF } from "jspdf";
            function gerarPDF() {
                const doc = new jsPDF();

                doc.text("Hello world!", 10, 10);
                doc.save("a4.pdf");
            }
        </script>

        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>