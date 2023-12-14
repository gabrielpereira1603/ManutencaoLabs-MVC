const btn_imp = document.getElementById("gerarPDF")

btn_imp.addEventListener("click",(evt)=>{
    const conteudo = document.getElementById('tabela-manutencao').innerHTML;

    let estilo = "<style>";
    estilo += "table {width: 100%, font: 20px Calibri;}";
    estilo += "table, th, td {border: solid 2px #888; border-collapse: collapse;}";
    estilo += "padding: 4px 8px;text-align:center;";
    estilo += "</style>";

    const win = window.open('', '', 'height=700, width=700');

    win.document.write('<hmtl><head>');
    win.document.write('<tittle>Manutenção Labs</tittle>');
    win.document.write(estilo);
    win.document.write('</head>');
    win.document.write('<body>');
    win.document.write(conteudo);
    win.document.write('</body></html>');

    win.print()
})