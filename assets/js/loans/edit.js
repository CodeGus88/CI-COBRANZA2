const selectCustomer = document.getElementById('customer_id');
const selectCashRegisters = document.getElementById('cash_register_id');
const selectCoin = document.getElementById('coin_id');
const userId = document.getElementById('user_id');
const cashRegisterId = document.getElementById('cash_register_id');
const creditAmount = document.getElementById('credit_amount');
const cashRegisterUpdate = document.getElementById('cash_register_update');
const coinId = document.getElementById('coin_id');
cashRegisters = [];

$(document).ready(function () {
    // Realiza la suma de las cuotas seleccionadas al registrar un nuevo prestamo
    $('#calcular').on('click', function () {
      // var define una variable global o local en una función sin importar el ámbito del bloque
      var contador = 0
  
      if ($("#customer_id").val() == "0" || $("#customer_id").val() == "") {
        contador = 1
        alert("Selecciona un cliente")
        $("#customer_id").focus()
        return false;
      }
  
      if ($("#credit_amount").val() == "") {
        contador = 1
        alert("Ingresar monto")
        $("#credit_amount").focus()
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
      // comparar caja
      if ($("#cash_register_id").val() == "") {
        contador = 1
        alert("Selecciona una caja")
        return false;
      }

      cashRegister = cashRegisters.find(element => element.id == cashRegisterId.value);
      if(cashRegister != null){
        if(Number.parseFloat(creditAmount.value) > Number.parseFloat(cashRegister.total_amount))
          alert("La caja no contiene el monto requerido ");
      }
      // fin comparar caja
  
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
      let monto = parseFloat($('#credit_amount').val());
      let num_cuotas = $('#fee').val();
      let i = ($('#in_amount').val() / 100);
      let I = monto * i * time;
      let monto_total = I + monto;
      let cuota = monto_total / num_cuotas;
  
      $('#valor_cuota').val(cuota.toFixed(2));
      $('#valor_interes').val(I.toFixed(2));
      $('#monto_total').val(monto_total.toFixed(2));
  
    }); 
  
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
    user_id = document.getElementById('user_id');
    user_name.value = '';
    user_id.value = '';
    id = document.getElementById('customer_id').value;
    if (id != 0) {
      x = customerList.find(x => x.id == id);
      user_name.value = x.user_name;
      user_id.value = x.user_id;
      customerList.forEach(element => {
        if (x.user_id == element.user_id && element.id != id) {
          let option = "<option value='" + element.id + "'>" + element.dni + " | " + element.fullname + "</option>";
          guarantorsItems.insertAdjacentHTML("beforeend", option);
        }
      });
      getCashRegisters(userId.value, selectCoin.value);
    }
  }

  async function getCashRegisters(user_id, coin_id){
    if(userId.value != '' && selectCoin.value != ''){
      fetch(`${base_url}admin/loans/ajax_get_cash_registers/${user_id}/${coin_id}`)
    .then(response => response.json()
    .then(json => {
      cashRegisters = json;
      while (cashRegisterId.firstChild) {
        cashRegisterId.removeChild(cashRegisterId.firstChild);
      };
      // console.log(json);
      json.forEach(element =>{
        option = `<option value="${element.id}">${element.name + " | Saldo: "+ element.total_amount + " " + element.short_name +""}</option>`;
        cashRegisterId.insertAdjacentHTML("beforeend", option);
      });
    }));
    }else{
      console.log('Seleccionar un usuario y una moneda');
    }
  }


selectCoin.addEventListener('change', (event) => {
  getCashRegisters(userId.value, selectCoin.value);
});

cashRegisterUpdate.addEventListener('click', event =>{
  getCashRegisters(userId.value, selectCoin.value);
});

function loanConfirmation(){
  cashRegister = cashRegisters.find(element => element.id == cashRegisterId.value);
  if(cashRegister != null )
    if(Number.parseFloat(creditAmount.value) > Number.parseFloat(cashRegister.total_amount)){
      alert(`La caja '${cashRegister.name} | ${cashRegister.total_amount + ' ' + cashRegister.short_name}' no contiene el monto suficiente para realizar está acción`);
    }else{
      return confirm(`Se procesará el préstamo de ${creditAmount.value + " " + coinId.options[coinId.selectedIndex].text}\n¿Quieres continuar?`);
    }
  // return false;
}