// Função para exibir o alerta de erro
function showErrorAlert(message) {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: message,
      showConfirmButton: true, 
      confirmButtonText: 'OK', 
    }).then((result) => {
      if (result.isConfirmed) {
        // Recarregue a página
        location.reload();
      }
    });
  }
  
  // Função para exibir o alerta de sucesso
  function showSucessoAlert(message) {
    Swal.fire({
      icon: 'success',
      title: 'Parabéns...',
      text: message,
      showConfirmButton: true, 
      confirmButtonText: 'OK', 
    }).then((result) => {
      if (result.isConfirmed) {
        // Recarregue a página
        location.reload();
      }
    });
  }