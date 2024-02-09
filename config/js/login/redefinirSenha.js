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
  
  