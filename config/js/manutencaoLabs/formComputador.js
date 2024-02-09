// Seleciona os elementos
var rangeInput = document.getElementById('rangeInput');
var patrimonioInput = document.getElementById('patrimonio');

// Adiciona um ouvinte de evento de mudança ao input range
rangeInput.addEventListener('input', function() {
// Atualiza o valor do input patrimonio com o valor atual do input range
patrimonioInput.value = rangeInput.value;
});

// Adiciona um ouvinte de evento de mudança ao input patrimonio
patrimonioInput.addEventListener('input', function() {
// Atualiza o valor do input range com o valor atual do input patrimonio
rangeInput.value = patrimonioInput.value;
});
document.getElementById("laboratorio").addEventListener("change", function () {
    var selectedLaboratorio = this.value;

    // Limpa o valor do campo de entrada quando o laboratório é alterado
    document.getElementById("patrimonio").value = '';

    fetch('?router=ManutencaoLabsController/getComputadores&codLaboratorio=' + selectedLaboratorio)
    .then(response => response.json())
    .then(jsonResponse => {
        var selectComputador = document.getElementById("computador");
        selectComputador.innerHTML = "<option value='-2'>Selecione um Computador</option>";

        jsonResponse.forEach(function (computador) {
            var option = document.createElement("option");
            option.value = computador.codcomputador;
            option.text = computador.patrimonio;
            selectComputador.appendChild(option);
        });

        // Atualiza o valor do campo de entrada com base no computador selecionado
        selectComputador.addEventListener("change", function() {
            var selectedComputador = this.value;
            var selectedComputerObj = jsonResponse.find(computer => computer.codcomputador == selectedComputador);
            // document.getElementById("patrimonio").value = selectedComputerObj ? selectedComputerObj.patrimonio : '';
        });
    });
});

function setAcaoPc(acao) {
    document.getElementById('acao-pc').value = acao;
}
