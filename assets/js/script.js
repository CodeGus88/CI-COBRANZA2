$(document).ready(function () {

  // Realiza la suma de las cuotas seleccionadas al registrar un nuevo prestamo
  $('#calcular').on('click', function () {
    // var define una variable global o local en una función sin importar el ámbito del bloque
    var contador = 0

    if ($("#search").val() == "0" || $("#search").val() == "") {
      contador = 1
      alert("Selecciona un cliente")
      $("#search").focus()
      return false;
    }

    if ($("#cr_amount").val() == "") {
      contador = 1
      alert("Ingresar monto")
      $("#cr_amount").focus()
      return false;
    }
    if ($("#time").val() == "") {
      contador = 1
      alert("Ingresar tiempo")
      $("#time").focus()
      return false;
    }

    if ($("#in_amount").val() == "") {
      contador = 1
      alert("Ingresar interés")
      $("#in_amount").focus()
      return false;
    }
    if ($("#date").val() == "") {
      contador = 1
      alert("Ingresar fecha emisión")
      return false;
    }

    if (contador == 0) {
      $('#register_loan').attr('disabled', false);
    }
    // let permite almacenar los datos de una forma más eficiente
    let time = parseFloat($('#time').val()); // n meses
    let payment = $('#payment').val(); // mensual, quincenal, semanal, diario
    if (payment.toLowerCase() == 'mensual') {
      $('#fee').val(time * 1);
    } else if (payment.toLowerCase() == 'quincenal') {
      $('#fee').val(time * 2);
    } else if (payment.toLowerCase() == 'semanal') {
      $('#fee').val(time * 4);
    } else if (payment.toLowerCase() == 'diario') {
      $('#fee').val(time * 30);
    } else {
      $('#fee').val(0);
    }
    let monto = parseFloat($('#cr_amount').val());
    let num_cuotas = $('#fee').val();
    let i = ($('#in_amount').val() / 100);
    let I = monto * i * time;
    let monto_total = I + monto;
    let cuota = monto_total / num_cuotas;

    $('#valor_cuota').val(cuota.toFixed(2));
    $('#valor_interes').val(I.toFixed(2));
    $('#monto_total').val(monto_total.toFixed(2));

  }); // Fin realiza la suma de las cuotas seleccionadas al registrar un nuevo prestamo

  $("#loan_form").submit(function () {
    if ($("#customer").val() == "") {
      alert("Buscar un cliente");
      return false;
    }
  });
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
  var symbol = $('#coin_type option:selected').data("symbol");
  if (start_d == '' || end_d == '') {
    alert('Ingrese las fechas')
    return;
  } else if (coin_id == '') {
    alert('Seleccione una moneda');
    return;
  }
  // $.get(base_url + "admin/reports/ajax_getCredits/" + coin_id + "/" + SELECTED_USER_ID, function (data) {
  $.get(base_url + "admin/reports/ajax_getCredits/" + coin_id + "/" + start_d + "/" + end_d + ((user_id != '') ? "/" + user_id : ''), function (data) {

    data = JSON.parse(data);
    // console.log('con parse', data)

    if (data.credits[0].sum_credit == null) {
      var sum_credit = '0 ' + symbol
    } else {
      var sum_credit = data.credits[0].sum_credit + ' ' + (data.credits[0].short_name).toUpperCase()
    }
    $("#cr").html(sum_credit) // id= cr -> total crédito

    if (data.credits[1].cr_interest == null) {
      var cr_interest = '0 ' + symbol
    } else {
      var cr_interest = data.credits[1].cr_interest + ' ' + (data.credits[1].short_name).toUpperCase()
    }
    $("#cr_interest").html(cr_interest) // id="cr_interest" -> Crédito con interes

    if (data.credits[2].cr_interestPaid == null) {
      var cr_interestPaid = '0 ' + symbol
    } else {
      var cr_interestPaid = data.credits[2].cr_interestPaid + ' ' + data.credits[2].short_name.toUpperCase()
    }
    $("#cr_interestPaid").html(cr_interestPaid) // id="cr_interestPaid" -> Total Credito cancelado con intere

    if (data.credits[3].cr_interestPay == null) {
      var cr_interestPay = '0 ' + symbol
    } else {
      var cr_interestPay = data.credits[3].cr_interestPay + ' ' + (data.credits[3].short_name).toUpperCase()
    }
    $("#cr_interestPay").html(cr_interestPay) // id="cr_interestPay" -> Total Credito por cobrar con interes
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

//  Funcion para cargar las cuotas de credito de un cliente al cobrar credito
function load_loan() {
  // alert("Este es un mensaje de javaScript: " + document.getElementById("search").value)
  customer_id = document.getElementById("search").value
  if (customer_id > 0) {
    fetch(base_url + "admin/payments/ajax_get_loan/" + customer_id)
      .then(response => response.json())
      .then(data => {
        // console.log(data);
        if (data.loan != null) {
          $("#customer_id").val(data.loan.customer_id);
          $("#loan_id").val(data.loan.id);
          $("#credit_amount").val(data.loan.credit_amount);
          $("#payment_m").val(data.loan.payment_m);
          $("#coin").val(data.loan.coin_name);
          $("#adviser").val(data.loan.user_name);
          $("#total_amount").val('');
          load_loan_items(data.loan.id);
          load_guarantors(data.loan.id);
        }
        else {
          alert('No se encontró un préstamo asociado al cliente seleccionado');
          window.location.reload();
        }
      })
  } else {
    document.getElementById("guarantors_container").style.display = "none"
    $('#register_loan').attr('disabled', true);
    clearform();
  }
}

function clearform() {
  $("#credit_amount").val('');
  $("#payment_m").val('');
  $("#coin").val('');
  $("#total_amount").val('');
  $("#quotas").dataTable().fnDestroy();
  $('#quotas').dataTable({
    "bPaginate": false, //Ocultar paginación
    "scrollY": '50vh',
    "scrollCollapse": true,
    "aaData": []
  })
}


function load_loan_items(loan_id) {
  // Consultar cuotas del préstamo
  fetch(base_url + "admin/payments/ajax_get_loan_items/" + loan_id)
    .then(responsex => responsex.json())
    .then(datax => {
      // console.log(datax)
      if (datax.quotas != null) { // Cargar tabla
        // cargar tabla de cuotas
        var x = new Array(datax.quotas.length);
        if (datax.quotas.length > 0) {
          for (i = 0; i < datax.quotas.length; i++) {
            const status = datax.quotas[i].status == 1 ? true : false;
            const fee_amount = datax.quotas[i].fee_amount;
            const id = datax.quotas[i].id;
            const num_quota = datax.quotas[i].num_quota;
            const date = datax.quotas[i].date;
            const payed = (datax.quotas[i].payed != null)?datax.quotas[i].payed:0;
            const payable = (fee_amount - payed).toFixed(2);
            // convenio de nombre para leer -> amount_quota_${id}
            const input = status ?
              `<input type='number' step=".01" min="0.01" max="${payable}" id='amount_quota_${id}' name='amount_quota_${id}' class='form-control col-md-12 text-center' onchange="calculateTotal();" disabled>`
              : '<small class="btn btn-success col-md-12">Completado<small>';
            x[i] = [
              `<input type="checkbox" name="quota_id[]" ${(status) ? "" : 'disabled checked'} data_fee='${payable}' num_quota='${num_quota}' value='${id}'>`,
              num_quota,
              date,
              fee_amount,
              payed,
              payable,
              input
            ]
          }
        }
        // clear the table before populating it with more data
        $("#quotas").dataTable().fnDestroy();
        $('#quotas').dataTable({
          "bPaginate": false, //Ocultar paginación
          "scrollY": '50vh',
          "scrollCollapse": true,
          "aaData": x
        })
        $('input:checkbox').on('change', function () {
          calculateTotal();
        });
      } else {
        $("#quotas").dataTable().fnDestroy();
        $('#quotas').dataTable({
          "bPaginate": false, //Ocultar paginación
          "scrollY": '50vh',
          "scrollCollapse": true,
          "aaData": null
        })
      }
    });
}

function calculateTotal() {
  $("#register_loan").attr("disabled", true);
  var total = 0;
  $('input:checkbox:enabled').each(function () {
    if ($(this).prop('checked')) {
      input_id = '#amount_quota_' + $(this).val()
      value = $(this).attr('data_fee');
      if ($(input_id).val() == '') $(input_id).val(value);
      $(input_id).attr("disabled", false);
      total += isNaN(parseFloat($(input_id).val())) ? 0 : parseFloat($(input_id).val());
    } else {
      input_id = '#amount_quota_' + $(this).val()
      value = '';
      $(input_id).val(value);
      $(input_id).attr("disabled", true);
      total += isNaN(parseFloat($(input_id).val())) ? 0 : parseFloat($(input_id).val());
    }
  });
  $("#total_amount").val(total.toFixed(2));
  setTimeout(() => { // Ayuda a que no se envie el formulario con la tecla enter
    if (total > 0)
      $("#register_loan").attr("disabled", false);
  }, 500);
}

// valida y pide confirmación antes de enviar el formulario para pagar
function payConfirmation() {
  try {
    total_amount = $("#total_amount").val()
    separator = "\n";
    errors = "";
    quotas = 0;
    formTotal = 0;
    quotasArray = new Array();
    if (isNaN(total_amount)) {
      errors += ((errors == '') ? '' : separator) + "- Ingrese un monto válido.";
    } else { // si total_amount es un número
      if (total_amount <= 0) errors += ((errors == '') ? '' : separator) + "- Debe ingregar un monto mayor a 0.";
      // Validar
      $('input:checkbox:enabled:checked').each(function () {
        formTotal += parseFloat($('#amount_quota_' + $(this).val()).val());
        const object = {
          quota_id: $(this).val(),
          num_quota: $(this).attr('num_quota'),
          quota_mount: $('#amount_quota_' + $(this).val()).val()
        };
        if (parseFloat(object.quota_mount) <= 0)
          errors += ((errors == '') ? '' : separator) + `- La cuota ${object.num_quota} debe ser mayor a 0.`;
        if (parseFloat(object.quota_mount) > parseFloat($(this).attr('data_fee')))
          errors += ((errors == '') ? '' : separator) + `- La cuota ${object.num_quota} no puede ser mayor a ${$(this).attr('data_fee')}.`;
        quotasArray[quotas] = object;
        quotas++;
      });
      formTotal = formTotal.toFixed(2)
      if (quotas <= 0) errors += ((errors == '') ? '' : separator) + "- Debe existir al menos una cuota seleccionada.";
      if (formTotal != total_amount) errors += ((errors == '') ? '' : separator) + "- El total no coincide con en el número de cuotas seleccionadas.";
    }
    if (errors == '') {
      strQuotas = "";
      quotasArray.forEach((quotaItem) => { strQuotas += `(${quotaItem.quota_id}) Cuota: ${quotaItem.num_quota}: ${quotaItem.quota_mount}\n`; });
      return confirm(
        `Número de cuotas: ${quotas}\n\n${strQuotas}\nTotal: ${total_amount}\n\n¿Continuar?`
      );
    } else {
      alert("ERRORES\n\n" + errors);
      return false;
    }
  } catch (e) {
    console.log(e);
    toastr["error"](e, 'ERROR');
    return false;
  }
}

function load_guarantors(loan_id) {
  fetch(base_url + "admin/payments/ajax_get_guarantors/" + loan_id)
    .then(response => response.json())
    .then(x => {
      // console.log(x);
      if (x.guarantors != null) {
        var options = "";
        x.guarantors.forEach(element => {
          var option = '<button type="button" class="btn btn-secondary margin-right" >' + element.ci + " | " + element.guarantor_name + '</button>';
          options += option;
        });
        $("#guarantors_contend").html("");
        document.getElementById("guarantors_container").style.display = (x.guarantors.length > 0) ? "" : "none"
        $("#guarantors_contend").html(options);
      }
    })
}


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


function loadGuarantorsOptions() {
  guarantorsItems = document.getElementById('guarantors');
  while (guarantorsItems.firstChild) {
    guarantorsItems.removeChild(guarantorsItems.firstChild);
  };
  user_name = document.getElementById('user_name');
  user_name.value = '';
  id = document.getElementById('search').value;
  if (id != 0) {
    x = customerList.find(x => x.id == id);
    user_name.value = x.user_name;
    customerList.forEach(element => {
      if (x.user_id == element.user_id && element.id != id) {
        let option = "<option value='" + element.id + "'>" + element.dni + " | " + element.fullname + "</option>";
        guarantorsItems.insertAdjacentHTML("beforeend", option);
      }
    });
  }
}
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
  // return true;
}


