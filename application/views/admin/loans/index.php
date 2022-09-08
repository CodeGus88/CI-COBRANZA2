<div class="card shadow mb-4">
  <div class="card-header d-flex align-items-center justify-content-between py-3">
    <h6 class="m-0 font-weight-bold text-primary">Lista de prestamos</h6>
    <?php if($LOAN_CREATE) : ?>
      <a class="d-sm-inline-block btn btn-sm btn-success shadow-sm" href="<?php echo site_url('admin/loans/edit'); ?>"><i class="fas fa-plus-circle fa-sm"></i> Nuevo prestamo</a>
    <?php endif ?>
  </div>
  <div class="card-body">
    <?php if ($this->session->flashdata('msg')): ?>
      <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <?= $this->session->flashdata('msg') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif ?>

    <?php if ($this->session->flashdata('msg_error')): ?>
      <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
        <?= $this->session->flashdata('msg_error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif ?>

    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>N° Prest.</th>
            <th>cliente</th>
            <th>Monto credito</th>
            <th>Monto interes</th>
            <th>Monto total</th>
            <th>T. moneda</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if(count($loans)): foreach($loans as $loan): ?>
            <tr>
                <?php
                  $time = 0; // en meses
                  if(strtolower($loan->payment_m)=='mensual'){
                    $time = $loan->num_fee/1;
                  }else if(strtolower($loan->payment_m)=='quincenal'){
                    $time = $loan->num_fee/2;
                  }else if(strtolower($loan->payment_m)=='semanal'){
                    $time = $loan->num_fee/4;
                  }else if(strtolower($loan->payment_m)=='diario'){
                    $time = $loan->num_fee/30;
                  }
                  $I = $loan->credit_amount * ($loan->interest_amount/100)*$time;
                  $total = $loan->credit_amount + $I;
                ?>
              <td><?php echo $loan->id ?></td>
              <td><?php echo $loan->customer ?></td>
              <td><?php echo round($loan->credit_amount,1) ?></td>
              <td>
                <?php echo round($I, 1); ?>
              </td>
              <td><?php echo round($total, 1); ?></td>
              <td style="text-transform:uppercase;"><?php echo $loan->short_name ?></td>
              <td>
                <button type="button" class="btn btn-sm <?php echo $loan->status ? 'btn-outline-danger': 'btn-outline-success' ?> status-check"><?php echo $loan->status ? 'Pendiente': 'Pagado' ?></button>
              </td>
              <td>
                <?php if($LOAN_ITEM_READ || ($AUTHOR_CRUD && $loan->user_id == $this->session->userdata('user_id')) ) :?>
                <a href="<?php echo site_url('admin/loans/view/'.$loan->id); ?>" class="btn btn-sm btn-secondary shadow-sm" data-toggle="ajax-modal"><i class="fas fa-eye fa-sm"></i> Ver pagos</a>
                <?php else :?>
                  Ninguno
                <?php endif ?>
              </td>
            </tr>
          <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center">No existen prestamos para mostrar.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"></div>