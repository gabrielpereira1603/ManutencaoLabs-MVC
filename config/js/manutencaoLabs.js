document.addEventListener('DOMContentLoaded', function() {
    // Função para verificar se o campo de entrada está vazio
    function verificarCampoVazio() {
        var campo = document.getElementById("nome-componente");
        var botoes = document.querySelectorAll(".btn");

        // Verifica se o campo está vazio
        if (campo.value.trim() === '') {
            // Campo vazio, desabilita os botões
            botoes.forEach(function(botao) {
                botao.disabled = true;
            });
        } else {
            // Campo não está vazio, habilita os botões
            botoes.forEach(function(botao) {
                botao.disabled = false;
            });
        }
    }

    document.getElementById("nome_componente").addEventListener("input", verificarCampoVazio);

});
