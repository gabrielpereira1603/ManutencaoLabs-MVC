document.addEventListener('DOMContentLoaded', function() {
    // Função para salvar os dados nos cookies
    function salvarDadosNosCookies() {
        var nomeCliente = document.getElementById('nomeCliente').value;
        var telefone = document.getElementById('telefone').value;
        var cursoNegociado = document.getElementById('cursoNegociado').value;
        var horarioInicio = document.getElementById('horario-inicio').value;
        var horarioFim = document.getElementById('horario-fim').value;
        var descricao = document.getElementById('descricao').value;
        var agendarRetorno = document.getElementById('agendarRetorno').value;

        document.cookie = 'nomeCliente=' + nomeCliente;
        document.cookie = 'telefone=' + telefone;
        document.cookie = 'cursoNegociado=' + cursoNegociado;
        document.cookie = 'horarioInicio=' + horarioInicio;
        document.cookie = 'horarioFim=' + horarioFim;
        document.cookie = 'descricao=' + descricao;
        document.cookie = 'agendarRetorno=' + agendarRetorno;
    }

    // Função para carregar os dados dos cookies quando a página é carregada
    window.onload = function() {
        var cookies = document.cookie.split(';');
        cookies.forEach(function(cookie) {
            var partes = cookie.split('=');
            var nome = partes[0].trim();
            var valor = partes[1];
            if (nome === 'nomeCliente') {
                document.getElementById('nomeCliente').value = valor;
            } else if (nome === 'telefone') {
                document.getElementById('telefone').value = valor;
            } else if (nome === 'cursoNegociado') {
                document.getElementById('cursoNegociado').value = valor;
            } else if (nome === 'horarioInicio') {
                document.getElementById('horario-inicio').value = valor;
            } else if (nome === 'horarioFim') {
                document.getElementById('horario-fim').value = valor;
            } else if (nome === 'descricao') {
                document.getElementById('descricao').value = valor;
            } else if (nome === 'agendarRetorno') {
                document.getElementById('agendarRetorno').value = valor;
            }
        });
    }

    // Chamar a função de salvar os dados nos cookies sempre que houver uma mudança nos campos do formulário
    document.getElementById('nomeCliente').addEventListener('input', salvarDadosNosCookies);
    document.getElementById('telefone').addEventListener('input', salvarDadosNosCookies);
    document.getElementById('cursoNegociado').addEventListener('input', salvarDadosNosCookies);
    document.getElementById('horario-inicio').addEventListener('input', salvarDadosNosCookies);
    document.getElementById('horario-fim').addEventListener('input', salvarDadosNosCookies);
    document.getElementById('descricao').addEventListener('input', salvarDadosNosCookies);
    document.getElementById('agendarRetorno').addEventListener('input', salvarDadosNosCookies);
});

function limparCookiesEFormulario(botaoClicado) {
    // Limpar os cookies
    var cookies = document.cookie.split(';');
    cookies.forEach(function(cookie) {
        var partes = cookie.split('=');
        var nome = partes[0].trim();
        document.cookie = nome + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT';
    });

    // Limpar os campos do formulário
    document.getElementById('nomeCliente').value = '';
    document.getElementById('telefone').value = '';
    document.getElementById('cursoNegociado').value = '';
    document.getElementById('horario-inicio').value = '';
    document.getElementById('horario-fim').value = '';
    document.getElementById('descricao').value = '';
    document.getElementById('agendarRetorno').value = '';


    // Exibir mensagem de acordo com o botão clicado
    if (botaoClicado === 'excluir') {
        // Exibir alerta de exclusão
        Swal.fire({
            position: "center",
            icon: "success",
            title: "O atendimento foi excluído",
            showConfirmButton: false,
            timer: 1500
        });
    } else if (botaoClicado === 'finalizar') {
        // Exibir alerta de finalização
        Swal.fire({
            position: "center",
            icon: "success",
            title: "O atendimento foi finalizado",
            showConfirmButton: false,
            timer: 1500
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Função para preencher o horário de início quando os campos forem preenchidos
    function preencherHorarioInicio() {
        var horarioInicioInput = document.getElementById('horario-inicio');
        var horarioFimInput = document.getElementById('horario-fim');

        // Verificar se o horário de início já está preenchido
        if (horarioInicioInput.value === '') {
            // Obter a data e hora atual
            var dataAtual = new Date();
            var hora = dataAtual.getHours();
            var minutos = dataAtual.getMinutes();

            // Formatar a hora e os minutos com dois dígitos
            hora = hora < 10 ? '0' + hora : hora;
            minutos = minutos < 10 ? '0' + minutos : minutos;

            // Montar o horário no formato HH:MM
            var horarioAtual = hora + ':' + minutos;

            // Preencher o campo de horário de início com o horário atual
            horarioInicioInput.value = horarioAtual;
        }
    }

    // Adicionar ouvinte de eventos aos campos que devem acionar o preenchimento do horário de início
    var camposMonitorados = document.querySelectorAll('#telefone, #nomeCliente, #cursoNegociado, #descricao, #observacoes');
    camposMonitorados.forEach(function(campo) {
        campo.addEventListener('input', preencherHorarioInicio);
    });

    // Chamar a função para preencher o horário de início quando a página é carregada
    preencherHorarioInicio();
});

