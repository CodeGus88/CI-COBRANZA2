<div class="card shadow mb-4">

  

  <div class="card-header d-flex align-items-center justify-content-between py-3">
    <h6 class="m-0 font-weight-bold text-primary">Lista de pagos</h6>
    <div>
      <?php
      if (isset($users)) : if (sizeof($users) > 0) :
          echo "<select class='custom-select-sm btn-outline-secondary' onchange='location = this.value;'>";
          $url = site_url('admin/payments');
          $selected = ($selected_user_id == 0) ? 'selected' : '';
          echo "<option value='$url' $selected>TODOS</option>";
          foreach ($users as $user) :
            $url = site_url("admin/payments/index/$user->id");
            $selected = ($selected_user_id == $user->id) ? 'selected' : '';
            $user_name = "$user->academic_degree $user->first_name $user->last_name";
            echo "<option value='$url' $selected>$user_name</option>";
          endforeach;
          echo "</select>";
        endif;
      endif;
      ?>
      <?php if (($LOAN_ITEM_READ) || ($AUTHOR_LOAN_ITEM_READ)) : 
        $parameter = (isset($selected_user_id))?(($selected_user_id != 0)?$selected_user_id:''):'';  
      ?>
        <a href="<?php echo site_url("admin/payments/quotes_week/$parameter") ?>" class="btn btn-sm btn-info shadow-sm" data-toggle="ajax-modal"><i class="fas fa-eye fa-sm"></i> Semana</a>
      <?php endif ?>
      <?php if (($AUTHOR_LOAN_UPDATE && $AUTHOR_LOAN_ITEM_UPDATE) || ($LOAN_UPDATE && $LOAN_ITEM_UPDATE)) : ?>
        <a class="d-sm-inline-block btn btn-sm btn-success shadow-sm" href="<?php echo site_url('admin/payments/edit'); ?>"><i class="fas fa-plus-circle fa-sm"></i> Realizar Pago</a>
      <?php endif ?>
    </div>
  </div>
  <div class="card-body">

  <?php if ($this->session->flashdata('msg')) : ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
      <?= $this->session->flashdata('msg') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php endif ?>

  <?php if ($this->session->flashdata('msg_error')) : ?>
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
            <th>CI</th>
            <th>cliente</th>
            <th>N° Prest.</th>
            <th>N° cuota</th>
            <th>M. cancelado</th>
            <th>Fecha pago</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($payments)) : foreach ($payments as $py) : ?>
              <tr>
                <td><?php echo $py->dni ?></td>
                <td><?php echo $py->name_cst ?></td>
                <td><?php echo $py->loan_id ?></td>
                <td><?php echo $py->num_quota ?></td>
                <td><?php echo $py->fee_amount ?></td>
                <td><?php echo $py->pay_date ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="6" class="text-center">No existen pagos para mostrar</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php if ($this->session->flashdata('document_payment_id')) : 
  $url = site_url('admin/payments/document_payment/'.$this->session->flashdata('document_payment_id'));
  echo "<script>
    window.open('$url', '_blank');
    window.focus();
  </script>";
endif ?>

<div class="modal fade" id="myModal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"></div>