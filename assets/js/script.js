
$(document).ready(function () {
  $(document).on("click", '[data-toggle="ajax-modal"]', function (t) {
    t.preventDefault();
    var url = $(this).attr("href");
    $.get(url).done(function (data) {
      $("#myModal").html(data).modal({ backdrop: "static" });
    })
  })
})

function deleteConfirm(elementId, title, message) {
  Swal.fire({
    title: title,
    text: message,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, ¡Eliminar esto!',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      btndelete = document.getElementById('delete' + elementId);
      btndelete.click();
    }
  })
}

function deleteConfirmation(title, message, url) {
  Swal.fire({
    title: title,
    text: message,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, ¡Eliminar esto!',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  })
  return false;
}

// imprimir
function printElementById(name, title = 'REPORTE', secondaryTitle = null) {
  var printContents = document.getElementById(name)
  var ventana = window.open(' ', 'PRINT');
  ventana.document.write('<html><head><title>ECOMSOFT - REPORTES</title>');
  ventana.document.write('<link rel="stylesheet" href="' + print_style + '">');
  ventana.document.write('</head><body>');
  if (title != null && title != '') {
    ventana.document.write('<center><h5>' + title + '</h5></center>');
  }
  if (secondaryTitle != null && secondaryTitle != '') {
    ventana.document.write('<center><h6>' + secondaryTitle + '</h6></center>');
  }
  ventana.document.write(printContents.innerHTML);
  ventana.document.write('</body></html>');
  ventana.document.close();
  ventana.focus();
  ventana.onload = function () {
    ventana.print();
    ventana.close();
  };
}


