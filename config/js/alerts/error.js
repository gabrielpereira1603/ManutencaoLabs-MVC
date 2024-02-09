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