<?php
namespace app\controllers;

// Importe o modelo necessário
use app\models\LaboratorioModel;

class LaboratorioController
{
    public function listarLaboratorios() {
        // Lógica para buscar laboratórios no banco de dados usando um modelo
        $laboratorios = LaboratorioModel::buscarLaboratorios();
    
        // Renderiza a view e passa os laboratórios como dados
        include('views/menuAdm.php');
    }
}
?>
