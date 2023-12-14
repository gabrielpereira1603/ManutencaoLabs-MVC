<?php

namespace app\controllers;

use app\models\RelatorioModel;

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

        // Armazene os dados na sessão
        $_SESSION['resultado_manutencao'] = $resultado;

        header("Location: ?router=Site/resultadoManutencao");
    }
    
    
}