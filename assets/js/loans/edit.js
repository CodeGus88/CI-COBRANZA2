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
  })


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