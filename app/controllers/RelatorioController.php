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
    
            // Return the response to the client (in this case, as JSON).
            header('Content-Type: application/json');

            echo  json_encode($computadores);
        }  
    }

    public function getAllComputadores() {
         $relatorioModel = new RelatorioModel();

         $computadores = $relatorioModel->todosPc();

        // Return the response to the client (in this case, as JSON).
        header('Content-Type: application/json');

        echo  json_encode($computadores);
    }

    public function relatorioManutencao() {
        // Verifica se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtém os dados do formulário
            $usuarioadmin = $_POST['usuarioadmin'];
            $codLaboratorio = $_POST['laboratorio'];
    
            // Verifica se o campo computador está definido
            $codComputador = isset($_POST['computador']) ? $_POST['computador'] : "";
            echo "CodComputador: $codComputador";
    
            $dataInicio = $_POST['dataInicio'];
            $dataFim = $_POST['dataFim'];
    
            $relatorioModel = new RelatorioModel();
    
            $resultado = $relatorioModel->Manutencao($usuarioadmin, $codLaboratorio, $codComputador, $dataInicio, $dataFim);
        }

        var_dump($_POST['usuarioadmin']);
        var_dump($_POST['laboratorio']);
        var_dump($_POST['computador']);
        var_dump($_POST['dataInicio']);
    
        print_r($resultado); // ou var_dump($suaVariavel);
        var_dump($resultado);
        return $resultado;
    }
    
    
}