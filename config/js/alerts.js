// Função para exibir o alerta de erro
function showErrorAlert(message) {
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: message,
    showConfirmButton: true, // Mostra o botão de confirmação "OK"
    confirmButtonText: 'OK', // Texto no botão "OK"
  }).then((result) => {
    if (result.isConfirmed) {
      // Recarregue a página
      location.reload();
    }
  });
}

function showSweetAlert() {
  Swal.fire('Sua PRIMEIRA  senha foi gerada com base no número do seu RG e na sua data de nascimento. \n\n Tratase de uma senha de 06 (seis) dígitos númerico, composta dos 04 (quatro) primeiro números do seu RG, seguido dos 02 (dois) últimos numero do ano de sua data de nascimento. \n\n Supondo que o número do seu RG seja 12.543.678-X, e que voce tenha nascido no ano de 1989, seu senha será: 125489');
}


//funcao alert esqueceu a senha!
document.addEventListener('DOMContentLoaded', function () {
  // Função para exibir o SweetAlert para solicitar o email
  function promptForEmail() {
    Swal.fire({
        title: 'Informe seu email',
        text: 'Enviaremos um email com link de redefinição de senha',
        input: 'email',
        inputAttributes: {
            autocapitalize: 'off',
            autocorrect: 'off',
        },
        showCancelButton: true,
        confirmButtonText: 'Enviar',
        showLoaderOnConfirm: true,
        preConfirm: (email) => {
            return $.ajax({
                type: 'POST',
                url: '?router=UsuarioController/enviarEmailRedefinicao',
                data: { email: email },
                dataType: 'json',
            })
            .done(function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Resultado',
                        text: response.mensagem,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: response.mensagem || 'Ocorreu um erro ao enviar o email. Tente novamente mais tarde.'
                    });
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Ocorreu um erro ao enviar o email. Tente novamente mais tarde.',
                });
                console.log('Erro na solicitação AJAX:', textStatus, errorThrown);
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    });
  }

  
  // Vincule a função `promptForEmail` ao botão "Esqueceu a senha?"
  const esqueceuSenhaButton = document.querySelector('#esqueceu-senha-button');
  esqueceuSenhaButton.addEventListener('click', function (event) {
    event.preventDefault(); // Evita que o link redirecione
    promptForEmail(); // Chama a função para solicitar o email
  });
});
