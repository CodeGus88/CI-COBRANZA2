<div class="card shadow mb-4">
  <div class="card-header d-flex align-items-center justify-content-between py-3">
    <h6 class="m-0 font-weight-bold text-primary">Lista de pagos</h6>
    <div>
      <?php
      if(isset($users)) : if(sizeof($users)>0) :
        echo "<select class='custom-select-sm btn-outline-secondary' onchange='location = this.value;'>";
          $url = site_url('admin/payments');
          $selected = ($selected_user_id == 0)?'selected':'';
          echo "<option value='$url' $selected>TODOS</option>";
          foreach($users as $user) :
            $url = site_url("admin/payments/index/$user->id");
            $selected = ($selected_user_id == $user->id)?'selected':'';
            $user_name = "$user->academic_degree $user->first_name $user->last_name";
            echo "<option value='$url' $selected>$user_name</option>";
          endforeach;
        echo "</select>";
      endif; endif;
      ?>
      <?php if (($AUTHOR_LOAN_UPDATE && $AUTHOR_LOAN_ITEM_UPDATE) || ($LOAN_UPDATE && $LOAN_ITEM_UPDATE)) : ?>
        <a class="d-sm-inline-block btn btn-sm btn-success shadow-sm" href="<?php echo site_url('admin/payments/edit'); ?>"><i class="fas fa-plus-circle fa-sm"></i> Realizar Pago</a>
      <?php endif ?>
    </div>
  </div>
  <div class="card-body">
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


<div class="modal fade" id="myModal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"></div>