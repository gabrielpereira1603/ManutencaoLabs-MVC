<?php

namespace app\controllers;

use app\models\RelatorioModel;


require_once('vendor\tecnickcom\tcpdf\tcpdf.php');
require_once('app\libraries\MYPDF.php'); 

class RelatorioController extends RelatorioModel
{
    public function getLaboratorio() {
        if (isset($_GET['codLaboratorio'])) {
            $codLaboratorio = $_GET['codLaboratorio'];

            $relatorioModel = new RelatorioModel();
            $computadores = $relatorioModel->getComputadores($codLaboratorio);
    
            header('Content-Type: application/json');
            echo  json_encode($computadores);
        }  
    }

    public function getAllComputadores() {
         $relatorioModel = new RelatorioModel();

         $computadores = $relatorioModel->todosPc();

        header('Content-Type: application/json');

        echo  json_encode($computadores);
    }

    public function relatorioManutencao() {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuarioadmin = $_POST['usuarioadmin'];
            $codLaboratorio = $_POST['laboratorio'];
            $codComputador = isset($_POST['computador']) ? $_POST['computador'] : "";    
            $dataInicio = $_POST['dataInicio'];
            $dataFim = $_POST['dataFim'];
    
            $relatorioModel = new RelatorioModel();
            $resultado = $relatorioModel->Manutencao($usuarioadmin, $codLaboratorio, $codComputador, $dataInicio, $dataFim);
        }

        $_SESSION['resultado_manutencao'] = $resultado;

        header("Location: ?router=Site/resultadoManutencao");
    }
    
    public function relatorioComponente() {
        session_start();
        $componentesSelecionados = isset($_POST['componente']) ? $_POST['componente'] : [];
        $codLaboratorio = $_POST['laboratorio'];
        $dataI = $_POST['dataInicio'];
        $dataF = $_POST['dataFim'];

        $dataInicio = date('Y-m-d', strtotime($_POST['dataInicio']));
        $dataFim = date('Y-m-d', strtotime($_POST['dataFim']));
    
        $componentes = implode(', ', $componentesSelecionados);
        
        $relatorioModel = new RelatorioModel();
        $resultadoComponente = $relatorioModel->Componente($componentes, $codLaboratorio, $dataInicio, $dataFim);
    
        $_SESSION['resultado_componentes'] = $resultadoComponente;
        header("Location: ?router=Site/resultadoComponente");
    }

    public function baixarPDF() 
    {
        session_start();
        // Verifique se 'dados_manutencao' está definido no $_POST
        if(isset($_POST['dados_manutencao'])) {
            $data = [
                ['2024-02-06 14:37:51', 'manutencao concluida com sucesso', 'Nome Aleatório', '123', 3, 'concluída', '01', 'Laboratório 1', 'teste\r\n', '2024-02-06 13:13:46', 'Mouse']
            ];
           
            //  print_r($dados);
            // Cria um novo documento PDF
            $pdf = new \MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
            // Define as informações do documento
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Nicola Asuni');
            $pdf->SetTitle('Relatório de Manutenção');
            $pdf->SetSubject('Relatório de Manutenção');
            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        
            // Define dados do cabeçalho
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Relatório de Manutenção', 'Relatório de Manutenção');
        
            // Define fontes, margens e outras configurações
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
            // Adiciona uma página
            $pdf->AddPage();
        
            // Define os títulos das colunas
            $header = array('Data/Hora Manutenção', 'Descrição Manutenção', 'Nome Usuário', 'Login', 'Nível de Acesso', 'Status Reclamação', 'Patrimônio Computador', 'Número Laboratório', 'Descrição Reclamação', 'Data/Hora Reclamação', 'Componentes');
        
            // Cria a tabela colorida com os dados
            $pdf->ColoredTable($header, $data);
        
            // Fecha e gera o PDF para download
            $pdf->Output('relatorio_manutencao.pdf', 'D');
        } else {
            // Se 'dados_manutencao' não estiver definido no $_POST, faça o tratamento apropriado
            echo "Dados de manutenção não foram recebidos.";
         }
    }
}