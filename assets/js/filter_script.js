function customersFilter(){
    // nombre de la tabla dataTable
    select = document.getElementById('user_id');
    fetch(base_url + "admin/customers/ajax_filter_customers_by_user/" + select.value)
    .then(res => res.json())
    .then(datax => {
      console.log(datax)
      if (datax.customers != null) { // Cargar tabla
        // cargar tabla de cuotas
        var x = new Array(datax.customers.length);
        if (datax.customers.length > 0) {
          for (i = 0; i < datax.customers.length; i++) {
            options = '';
            
            
            if(CUSTOMER_UPDATE || (AUTHOR_CUSTOMER_UPDATE && datax.customers[i].user_id == USER_ID)){
              options +=`<a href="${base_url+'admin/customers/edit/'+datax.customers[i].id}" class="btn btn-sm btn-info shadow-sm">Editar</a>`
            }
            if(CUSTOMER_DELETE || (AUTHOR_CUSTOMER_DELETE && datax.customers[i].user_id == USER_ID)){
              options += `<a onclick="return deleteConfirm(${datax.customers[i].id}, 
              '¿Estas seguro?', '¡No podrás revertir esto!   Eliminar cliente: (${datax.customers[i].dni}) ${datax.customers[i].first_name}  ${datax.customers[i].last_name}')"  class="btn btn-sm btn-danger shadow-sm">
                Eliminar <a href="${base_url+'admin/customers/delete/'+datax.customers[i].id}" id="delete${datax.customers[i].id}" hidden></a>
              </a>`
            }

            x[i] = [
              datax.customers[i].dni,
              datax.customers[i].first_name,
              datax.customers[i].last_name,
              datax.customers[i].gender,
              datax.customers[i].mobile,
              datax.customers[i].company,
            //   <button type="button" class="btn btn-sm <?php echo $ct->loan_status ? 'btn-outline-danger' : 'btn-outline-success' ?> status-check"><?php echo $ct->loan_status ? 'Con Crédito' : 'Sin Crédito' ?></button>
              `<button type="button" class="btn btn-sm ${(datax.customers[i].loan_status==true)? "btn-outline-danger" : "btn-outline-success"} status-check"> ${(datax.customers[i].loan_status==true)? 'Con Crédito' : 'Sin Crédito' }</button>`,
              options
            ]
          }
        }
        // clear the table before populating it with more data
        $("#dataTable").dataTable().fnDestroy();
        $('#dataTable').dataTable({
          "bPaginate": true, //Ocultar paginación
        //   "scrollY": '50vh',
          "scrollCollapse": false,
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
      }else{
        $("#dataTable").dataTable().fnDestroy();
        $('#dataTable').dataTable({
          "bPaginate": false, //Ocultar paginación
          "scrollY": '50vh',
          "scrollCollapse": true,
          "aaData": null
        })
      }
    });
  
}

// console.log('CUSTOMER_UPDATE: ' + CUSTOMER_UPDATE);
// console.log('AUTHOR_CUSTOMER_UPDATE: ' + AUTHOR_CUSTOMER_UPDATE);
// console.log('CUSTOMER_DELETE: ' + CUSTOMER_DELETE);
// console.log('AUTHOR_CUSTOMER_DELETE: ' + AUTHOR_CUSTOMER_DELETE);