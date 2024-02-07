<?php
require_once('vendor\tecnickcom\tcpdf\tcpdf.php');

// Estende o TCPDF com funções personalizadas
class MYPDF extends TCPDF {
    // Tabela colorida
    public function ColoredTable($data) {
        // Definir cores e fonte para os dados
        $this->SetFillColor(224, 235, 255); // Cor de fundo azul claro
        $this->SetTextColor(0); // Cor do texto preto
        $this->SetFont(''); // Fonte regular

        // Imprimir dados
        foreach ($data as $row) {
            $this->Row($row);
        }
    }

    // Criar uma linha
    function Row($data) {
        foreach ($data as $cell) {
            // Definir altura da linha
            $h = 6;
            $this->checkPageBreak($h); // Ajuste aqui para chamar o método checkPageBreak() da classe TCPDF
            
            // Desenhar célula
            $this->Cell(40, $h, $cell, 'LR', 0, 'L', 0);
        }
        $this->Ln($h);
    }
    
}