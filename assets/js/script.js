// Se movio $(document).ready(function () {...
$(document).ready(function () {
  $(document).on("click", '[data-toggle="ajax-modal"]', function (t) {
    t.preventDefault();
    var url = $(this).attr("href");
    $.get(url).done(function (data) {
      $("#myModal").html(data).modal({ backdrop: "static" });
    })
  })
})

// Cargar
let report_title = '';
let date_range = '';
function loadGeneralReport() {
  const coin_id = $("#coin_type").val()
  const start_d = $("#start_d").val()
  const end_d = $("#end_d").val()
  const user_id = $("#user_id").val()
  var symbol = $('#coin_type option:selected').data("symbol").toUpperCase();
  if (start_d == '' || end_d == '') {
    alert('Ingrese las fechas')
    return;
  } else if (coin_id == '') {
    alert('Seleccione una moneda');
    return;
  }
  // $.get(base_url + "admin/reports/ajax_getCredits/" + coin_id + "/" + SELECTED_USER_ID, function (data) {
  $.get(base_url + "admin/reports/ajaxGetCredits/" + coin_id + "/" + start_d + "/" + end_d + ((user_id != '') ? "/" + user_id : ''), function (data) {

    data = JSON.parse(data);
    // console.log('con parse', data)

    if (data.credits[0].sum_credit == null) {
      var sum_credit = '0.00 ' + symbol
    } else {
      var sum_credit = data.credits[0].sum_credit + ' ' + (data.credits[0].short_name).toUpperCase()
    }
    $("#cr").html(sum_credit) // id= cr -> total crédito

    if (data.credits[1].cr_interest == null) {
      var cr_interest = '0.00 ' + symbol
    } else {
      var cr_interest = data.credits[1].cr_interest + ' ' + (data.credits[1].short_name).toUpperCase()
    }
    $("#cr_interest").html(cr_interest) // id="cr_interest" -> Crédito con interes

    if (data.credits[2].cr_interestPaid == null) {
      var cr_interestPaid = '0.00 ' + symbol
    } else {
      var cr_interestPaid = data.credits[2].cr_interestPaid + ' ' + data.credits[2].short_name.toUpperCase()
    }
    $("#cr_interestPaid").html(cr_interestPaid) // id="cr_interestPaid" -> Total Credito cancelado con intere

    if (data.credits[3].cr_interestPay == null) {
      var cr_interestPay = '0.00 ' + symbol
    } else {
      var cr_interestPay = data.credits[3].cr_interestPay + ' ' + (data.credits[3].short_name).toUpperCase()
    }
    $("#cr_interestPay").html(cr_interestPay)
    if (data.credits[4].mount_payed == null) {
      var mount_payed = '0.00 ' + symbol
    } else {
      var mount_payed = data.credits[4].mount_payed + ' ' + (data.credits[4].short_name).toUpperCase()
    }
    $("#mount_payed").html(mount_payed)
    if (data.credits[5].payable == null) {
      var payable = '0.00 ' + symbol
    } else {
      var payable = data.credits[5].payable + ' ' + (data.credits[5].short_name).toUpperCase()
    }
    $("#payable").html(payable)
    user_name = '';
    if (typeof data.selected_user === 'undefined') {
      report_title = '';
    } else if (data.selected_user.user_name.toLowerCase() == 'all') {
      report_title = 'RESUMEN GENERAL DE PRÉSTAMOS';
      user_name = 'TODOS';
    } else {
      report_title = 'RESUMEN DE PRÉSTAMOS - ' + data.selected_user.user_name;
      user_name = data.selected_user.user_name;
    }
    date_range = `${start_d} - ${end_d}`;
    $("#range_date").html('RANGO DE FECHAS: ' + date_range);
    toastr["success"](date_range, user_name);
    $("#message").html('USUARIO: ' + user_name);
    if (report_title != '')
      document.getElementById('alert_message').style.display = "block";
    else
      document.getElementById('alert_message').style.display = "none";
  });
}

function reportPDF() {
  var start_d = $("#start_d").val();
  var end_d = $("#end_d").val();
  var coin_t = $("#coin_type2").val();
  var user_selected_id = $("#user_selected").val() ? '/' + $("#user_selected").val() : !(typeof USER_ID === 'undefined') ? '/' + USER_ID : '';

  if (start_d == '' || end_d == '') {
    alert('Ingrese las fechas')
  } else {
    window.open(base_url + 'admin/reports/dates_pdf/' + coin_t + '/' + start_d + '/' + end_d + user_selected_id);
  }
}

// load loans (movido a payments) Funcion para cargar las cuotas de credito de un cliente al cobrar credito

// se movio clear form

// Se movio load_loan_items

// se movio calculateTotal

// validacion payments movido a payments

// Se movio load_guarantors

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


// Se movio loadGuarantorsOptions

// imprimir
function printElementById(name, title = 'REPORTE', secondaryTitle = null) {
  var printContents = document.getElementById(name)
  var ventana = window.open(' ', 'PRINT'); // 'height=400,width=600'
  ventana.document.write('<html><head><title>CrediChura Casa - Reportes</title>');
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


