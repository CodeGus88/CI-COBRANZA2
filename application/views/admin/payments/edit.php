<div class="card shadow mb-4">
  <div class="card-header py-3">Pagar cuotas del prestamo </div>
  <div class="card-body">

    <?php echo form_open('admin/payments/ticket'); ?>

    <div class="form-row">
      <div class="form-group col-12 col-md-12">
        <label class="small mb-1" for="exampleFormControlSelect2">Cliente</label>
        <div class="input-group">
          <select id="search" class="form-control" name="customer_id" onChange="load_loan()">
            <option value="0" selected="selected">...</option>
            <?php foreach ($customers as $customer) : ?>
              <option value="<?php echo $customer->id ?>">
                <?php echo  $customer->dni . " | " . $customer->fullname ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>
        <span class="small mb-1"><small>(Solo aparecen en la lista los clientes que tienen cuentas pendientes)</small></span>
      </div>
    </div>

    <div class="form-row" id="guarantors_container" style="display: none">
      <div class="form-group col-12 col-md-16">
        <label class="small mb-1" for="exampleFormControlSelect2">Garantes</label>
        <div class="input-group" id="guarantors_contend">

        </div>
        <span class="small mb-1"><small>Garantes del préstamo</small></span>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-12 col-md-16">
        <label class="small mb-1" for="exampleFormControlSelect2">Asesor</label>
        <input class="form-control" id="adviser" type="text" disabled>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-12 col-md-4">
        <input type="hidden" name="loan_id" id="loan_id">
        <label class="small mb-1" for="inputUsername">Monto prestado</label>
        <input class="form-control" id="credit_amount" type="text" readonly>
      </div>
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="inputUsername">Forma de pago</label>
        <input class="form-control" id="payment_m" type="text" disabled>
      </div>
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="exampleFormControlTextarea1">Tipo moneda</label>
        <input class="form-control" id="coin" name="coin" type="text" readonly>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-12 col-md-8">
        <table class="table table-bordered" id="quotas" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th><input type="checkbox" disabled></th>
              <th id='ncuota'>N° cuota</th>
              <th>Fecha de pago</th>
              <th>Monto cuota</th>
              <th>Estado</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="form-group col-12 col-md-4 text-center">
        <label class="small mb-1" for="exampleFormControlTextarea1">Monto total a pagar</label>
        <input class="form-control mb-3 text-center" style="font-weight: bold; font-size: 1.2rem;" id="total_amount" type="number" step="any" disabled>
        <div class="row">
          <div class="col-6">
            <button class="btn btn-success btn-block" id="register_loan" type="submit" disabled>Registrar Pago</button>
          </div>
          <div class="col-6">
            <a href="<?php echo site_url('admin/payments/'); ?>" class="btn btn-dark btn-block">Cancelar</a>
          </div>
        </div>
      </div>
    </div>

    <?php echo form_close() ?>

  </div>
</div>


<script>
  $("#search").select2({
    tags: false
  });
</script>