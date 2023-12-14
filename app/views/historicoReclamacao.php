<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Central De Manutenções</title>
        <link rel="shortcut icon" href="config/images/logo-five_icon.png" type="image/x-icon">
        <link rel="stylesheet" href="config/css/historicoReclamacao.css">
        <link rel="stylesheet" href="config/css/cabecario.css">
        <link rel="stylesheet" href="config/node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
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

        <div class="titulo">
            <h1>Reclamações em Aberto</h1>
        </div>

        <div class="container">
            <div class="table-responsive">
                <table class='table table-bordered table-striped' id="myTable">
                    <thead class='thead-dark'>
                        <tr>
                            <th>ID</th>
                            <th>Descrição</th>
                            <th>Status</th>
                            <th>Computador</th>
                            <th>Laboratório</th>
                            <th>Aluno</th>
                            <th>Componentes</th>
                            <th>Data/Hora da Reclamação</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
            
                        <?php foreach($buscarReclamacao as $reclamacao): ?> 
                            <tr>
                                <td><?php echo $reclamacao['codreclamacao']; ?></td>
                                <td> <?php echo $reclamacao['descricao']; ?></td>
                                <td> <?php echo $reclamacao['status']; ?></td>
                                <td> <?php echo $reclamacao['patrimonio']; ?></td>
                                <td> <?php echo $reclamacao['numerolaboratorio']; ?></td>
                                <td> <?php echo $reclamacao['nome_usuario']; ?></td>
                                <td><?php echo $reclamacao['componentes']; ?></td>
                                <td><?php echo $reclamacao['datahora_reclamacao']; ?></td>
                                <td>
                                    <form action="?router=ReclamacaoController/editarReclamacao" method="POST">
                                        <input type="hidden" name="codreclamacao" value="<?php echo $reclamacao['codreclamacao']; ?>">
                                        <input type="hidden" name="numerolaboratorio" value="<?php echo $reclamacao['numerolaboratorio']; ?>">
                                        <input type="hidden" name="patrimonio" value="<?php echo $reclamacao['patrimonio']; ?>">
                                        <button class="btn-editar"><i class="bi bi-pencil-square"></i></button>                           
                                      
                                    </form>
                                </td> 
                            </tr> 
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>

        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    "language": {
                        "sEmptyTable": "Nenhum dado disponível na tabela",
                        "sInfo": "Mostrando _START_ até _END_ de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                        "sInfoFiltered": "(filtrado de _MAX_ registros no total)",
                        "sInfoPostFix": "",
                        "sInfoThousands": ".",
                        "sLengthMenu": "_MENU_ resultados por página",
                        "sLoadingRecords": "Carregando...",
                        "sProcessing": "Processando...",
                        "sZeroRecords": "Nenhum registro encontrado",
                        "sSearch": "Pesquisar:",
                        "oPaginate": {
                            "sNext": "Próximo",
                            "sPrevious": "Anterior",
                            "sFirst": "Primeiro",
                            "sLast": "Último"
                        },
                        "oAria": {
                            "sSortAscending": ": Ordenar colunas de forma ascendente",
                            "sSortDescending": ": Ordenar colunas de forma descendente"
                        },
                        "select": {
                            "rows": {
                                "_": "Selecionado %d linhas",
                                "0": "Nenhuma linha selecionada",
                                "1": "Selecionado 1 linha"
                            }
                        }
                    }
                });
            });
        </script>

        <script src="config/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>