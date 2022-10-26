<div class="card shadow mb-4">
  <div class="card-header py-3">Crear préstamo </div>
  <div class="card-body">
    <?php if (validation_errors()) { ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo validation_errors('<li>', '</li>'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php } ?>
    <?php echo form_open('admin/loans/edit', 'id="loan_form"'); ?>

    <div class="form-row">
      <div class="form-group col-12 col-md-12">
        <label class="small mb-1" for="exampleFormControlSelect2">Cliente</label>
        <div class="input-group">
          <select id="search" class="form-control form-select" name="customer_id" onchange="loadGuarantorsOptions()">
            <option value="0" selected="selected">...</option>
            <?php foreach ($customers as $customer) : ?>
              <?php if ($customer->loan_status == FALSE) : ?>
                <option value="<?php echo $customer->id ?>">
                  <?php
                  echo  $customer->dni . " | " . $customer->fullname ?>
                </option>
              <?php endif ?>
            <?php endforeach ?>
          </select>
        </div col-12 col-md-12>
        <span class="small mb-1"><small id="customerRectriction">Solo aparecen en la lista los clientes que no tienen cuentas pendientes.</small></span>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-12 col-md-12">
        <label class="small mb-1" for="exampleFormControlSelect2">Garantes</label>
        <div class="input-group">
          <select id="guarantors" class="form-control form-select" name="guarantors[]" multiple="multiple">
          </select>
        </div>
        <span class="small mb-1"><small id="guarantorsRestriction">Máximo 9 garantes.</small></span>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-12 col-md-12">
        <label class="small mb-1" for="exampleFormControlTextarea1">Asesor de grupo</label>
        <input class="form-control" id="user_name" type="text" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="inputUsername">Monto préstamo (capital)</label>
        <input class="form-control" id="cr_amount" type="number" name="credit_amount" step="none" min="1">
      </div>
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="inputUsername">Tasa de interés %</label>
        <select class="form-control" type="number" id="in_amount" name="interest_amount">
          <option value="10">10%</option>
          <option value="11">11%</option>
          <option value="12">12%</option>
          <option value="13">13%</option>
          <option value="14" selected>14%</option>
          <option value="15">15%</option>
          <option value="16">16%</option>
          <option value="17">17%</option>
          <option value="18">18%</option>
          <option value="19">19%</option>
          <option value="20">20%</option>
        </select>
      </div>

      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="exampleFormControlSelect2">Modalidad de pago</label>
        <select class="form-control" id="payment" name="payment_m">
          <option value="diario">Diario</option>
          <option value="semanal">Semanal</option>
          <option value="quincenal" selected="selected">Quincenal</option>
          <option value="mensual">Mensual</option>
        </select>
      </div>
    </div>

    <div class="form-row">

      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="exampleFormControlTextarea1">Tiempo (meses)</label>
        <input class="form-control" min="1" id="time" type="number" name="time">
      </div>

      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="exampleFormControlTextarea1">Nro cuotas</label>
        <input class="form-control" id="fee" type="number" name="num_fee" readonly="readonly">
      </div>

      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="exampleFormControlSelect2">Tipo moneda</label>
        <select class="form-control" id="exampleFormControlSelect2" name="coin_id">
          <?php foreach ($coins as $coin) : ?>
            <option <?php if(strtolower($coin->name)=='bolivianos') echo 'selected' ?> value="<?php echo $coin->id ?>"><?php echo $coin->short_name ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="inputUsername">Fecha emisión</label>
        <input class="form-control" id="date" type="date" name="date">
      </div>
    </div>

    <div class="form-group">
      <button class="btn btn-success" type="button" id="calcular">Calcular</button>
    </div>

    <div class="form-row">
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="inputUsername">Importe de la cuenta</label>
        <input class="form-control" id="valor_cuota" type="text" name="fee_amount" readonly>
      </div>
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="inputUsername">Interés</label>
        <input class="form-control" id="valor_interes" type="text" name="" disabled>
      </div>
      <div class="form-group col-12 col-md-4">
        <label class="small mb-1" for="exampleFormControlTextarea1">Monto total</label>
        <input class="form-control" id="monto_total" type="text" name="" disabled>
      </div>
    </div>

    <button class="btn btn-primary" id="register_loan" type="submit" disabled>Registrar Prestamo</button>
    <a href="<?php echo site_url('admin/loans/'); ?>" class="btn btn-dark">Cancelar</a>

    <?php echo form_close() ?>

  </div>
</div>
<script>
  customerList = <?php echo json_encode($customers); ?>
</script>
<script>
  $("#search").select2({
    tags: false
  });
</script>

<script>
  $('#guarantors').select2({
    tags: false,
    tokenSeparators: [' | '],
    maximumSelectionLength: 9
  })
</script>

<script src="<?= site_url() . 'assets/js/loans/edit.js' ?>"></script>