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
  
  