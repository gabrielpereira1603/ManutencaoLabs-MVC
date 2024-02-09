document.getElementById('nomelaboratorio').addEventListener("change", function () {
    var selectedLaboratorio = this.value;
    if (selectedLaboratorio === "") {
        // Limpar o campo se "Selecione um Laboratório" for escolhido
        document.getElementById("nomeLaboratorio").value = "";
    } else {
        // Caso contrário, obter e exibir o nome do laboratório
        var numerolaboratorio = document.querySelector(`option[value="${selectedLaboratorio}"]`).text;
        document.getElementById("nomeLaboratorio").value = numerolaboratorio;
    }
});

function setAcaoLab(acao) {
    document.getElementById('acao-labs').value = acao;
}
