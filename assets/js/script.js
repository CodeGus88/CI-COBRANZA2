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
      alert("Ingresar interes")
      $("#in_amount").focus()
      return false;
    }
    if ($("#date").val() == "") {
      contador = 1
      alert("Ingresar fecha emision")
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
    // let I = monto * i * num_cuotas;
    let I = monto * i * time;
    let monto_total = I + monto;
    let cuota = monto_total / num_cuotas;

    $('#valor_cuota').val(cuota.toFixed(1));
    $('#valor_interes').val(I.toFixed(1));
    $('#monto_total').val(monto_total.toFixed(1));

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

  $("#coin_type").change(function () {
    loadGeneralReport()
  });
  // $("#coin_type").change(loadGeneralReport());

})

// loadGeneralReport();

// Cargar 
function loadGeneralReport() {
  var coin_id = $("#coin_type").val()
  var symbol = $('#coin_type option:selected').data("symbol");

  $.get(base_url + "admin/reports/ajax_getCredits/" + coin_id, function (data) {

    data = JSON.parse(data);
    console.log('con parse', data)

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

  });
}



function imp_credits(imp1) {
  var printContents = document.getElementById('imp1').innerHTML;
  w = window.open();
  w.document.write(printContents);
  w.print();
  w.close();
}

function reportPDF() {
  var start_d = $("#start_d").val();
  var end_d = $("#end_d").val();
  var coin_t = $("#coin_type2").val();

  if (start_d == '' || end_d == '') {
    alert('Ingrese las fechas')
  } else {
    window.open(base_url + 'admin/reports/dates_pdf/' + coin_t + '/' + start_d + '/' + end_d)
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
        console.log(data);
        if (data.loan != null) {
          $("#customer_id").val(data.loan.customer_id);
          $("#loan_id").val(data.loan.id);
          $("#credit_amount").val(data.loan.credit_amount);
          $("#payment_m").val(data.loan.payment_m);
          $("#coin").val(data.loan.coin_name);
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
      console.log(datax)
      if (datax.quotas != null) { // Cargar tabla
        // cargar tabla de cuotas
        var x = new Array(datax.quotas.length);
        if (datax.quotas.length > 0) {
          for (i = 0; i < datax.quotas.length; i++) {
            x[i] = [
              '<input type="checkbox" name="quota_id[]" ' + (datax.quotas[i].status == 1 ? '' : 'disabled checked') + ' data-fee=' + datax.quotas[i].fee_amount + ' value=' + datax.quotas[i].id + '>',
              datax.quotas[i].num_quota,
              datax.quotas[i].date,
              datax.quotas[i].fee_amount,
              '<button type="button" class="btn btn-sm ' + (datax.quotas[i].status == 1 ? 'btn-outline-danger' : 'btn-outline-success') + '">' + (datax.quotas[i].status == 1 ? 'Pendiente' : 'Pagado') + '</button>'
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
          var total = 0;
          $('input:checkbox:enabled:checked').each(function () {
            total += isNaN(parseFloat($(this).attr('data-fee'))) ? 0 : parseFloat($(this).attr('data-fee'));
          });

          $("#total_amount").val(total.toFixed(1));

          if (total != 0 && $("#search").val() != 0) {
            $('#register_loan').attr('disabled', false);
          } else {
            $('#register_loan').attr('disabled', true);
          }
        });
      }
    });
}

function load_guarantors(loan_id) {
  fetch(base_url + "admin/payments/ajax_get_guarantors/" + loan_id)
    .then(response => response.json())
    .then(x => {
      console.log(x);
      if (x.guarantors != null) {
        var options = "";
        x.guarantors.forEach(element => {
          var option = '<button type="button" class="btn btn-secondary margin-right" >' + element.ci + " | " + element.guarantor_name + '</button>';

          options += option;
        });
        document.getElementById("guarantors_container").style.display = (x.guarantors.length > 0) ? "" : "none"
        $("#guarantors_contend").html("");
        $("#guarantors_contend").html(options);
      }
    })
}




function removeCustomer(id){
  if (confirm("¿Está seguro que desea eliminar el registro?")) {
    fetch(base_url + "admin/customers/delete/" + id,{
      method: 'DELETE'
    })
    .then(res => res.text()) // or res.json()
    .then(res => console.log(res))
  }
}

function deleteConfirm (title, message){
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
      btndelete = document.getElementById('delete');
      btndelete.click();
      
    }
  })
}