<?php

namespace app\controllers;

use app\models\RelatorioModel;
use app\controllers\TCPDF;

require_once('vendor\tecnickcom\tcpdf\tcpdf.php');

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
    $dados = json_decode($_POST['dados_manutencao']);    

    // Crie uma instância do TCPDF
    $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

}

    
}