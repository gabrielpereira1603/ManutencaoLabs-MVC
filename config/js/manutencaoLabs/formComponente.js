document.getElementById("select-componente").addEventListener("change", function () {
    var selectedComponenteCod = this.value;
    var nomeComponenteInput = document.getElementById("nome-componente");

    // Limpar o campo se a opção "Selecione um componente" for escolhida
    if (selectedComponenteCod === '') {
        nomeComponenteInput.value = '';
    } else {
        // Obter o texto da opção selecionada no select
        var selectedOption = this.options[this.selectedIndex];
        var nomeComponente = selectedOption.text;
        // Preencher o campo de entrada com o nome do componente
        nomeComponenteInput.value = nomeComponente;
    }
});

function setAcao(acao) {
    document.getElementById('acao-comp').value = acao;
}
