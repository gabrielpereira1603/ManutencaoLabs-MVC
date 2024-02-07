<?php

require_once('vendor\tecnickcom\tcpdf\tcpdf.php');


// Estende o TCPDF com funções personalizadas
class MYPDF extends TCPDF {

    // Carrega os dados da tabela a partir de um arquivo
    // public function CarregarDados($file) {
    //     // Lê as linhas do arquivo
    //     $lines = file($file);
    //     $data = array();
    //     foreach($lines as $line) {
    //         $data[] = explode(';', chop($line));
    //     }
    //     return $data;
    // }
    

    // Tabela colorida
    public function ColoredTable($header, $data) {
        // Cores, largura da linha e fonte em negrito
        $this->SetFillColor(255, 0, 0); // Define a cor de fundo como vermelho
        $this->SetTextColor(255); // Define a cor do texto como branco
        $this->SetDrawColor(128, 0, 0); // Define a cor da borda como vermelho escuro
        $this->SetLineWidth(0.3); // Define a largura da linha
        $this->SetFont('', 'B'); // Define a fonte como negrito

        // Cabeçalho
        $w = array(40, 35, 40, 45); // Largura de cada coluna
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 11, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln(); // Move para a próxima linha

        // Restauração das cores e da fonte
        $this->SetFillColor(224, 235, 255); // Define a cor de fundo como azul claro
        $this->SetTextColor(0); // Define a cor do texto como preto
        $this->SetFont(''); // Define a fonte como regular

        // Dados
        $preenchimento = 0; // Flag para determinar a cor de fundo
        foreach($data as $linha) {
            $this->Cell($w[0], 6, $linha[0], 'LR', 0, 'L', $preenchimento); // Desenha uma célula alinhada à esquerda
            $this->Cell($w[1], 6, $linha[1], 'LR', 0, 'L', $preenchimento); // Desenha uma célula alinhada à esquerda
            $this->Cell($w[2], 6, number_format($linha[2]), 'LR', 0, 'R', $preenchimento); // Desenha uma célula alinhada à direita com formatação numérica
            $this->Cell($w[3], 6, number_format($linha[3]), 'LR', 0, 'R', $preenchimento); // Desenha uma célula alinhada à direita com formatação numérica
            $this->Ln(); // Move para a próxima linha
            $preenchimento = !$preenchimento; // Alterna a cor de fundo
        }
        $this->Cell(array_sum($w), 0, '', 'T'); // Desenha a linha inferior da tabela
    }
}
