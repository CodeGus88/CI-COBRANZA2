<div class="card shadow mb-4">
  <div class="card-header d-flex align-items-center justify-content-between py-3">
    <h6 class="m-0 font-weight-bold text-primary">Reporte general por clientes</h6>
    <div class="row">
      <?php
      if (isset($users)) : if (sizeof($users) > 0) :
          echo '<select class="custom-select-sm btn-outline-secondary" onchange="location = this.value;">';
          $url = site_url('admin/reports/customers');
          $selected = ($selected_user_id == 0) ? 'selected' : '';
          echo "<option value='$url' $seleted>TODOS</option>";
          foreach ($users as $user) :
            $url = site_url('admin/reports/customers/' . $user->id);
            $selected = ($selected_user_id == $user->id) ? 'selected' : '';
            echo "<option value='$url' $selected>$user->academic_degree $user->first_name $user->last_name</option>";
          endforeach;
          echo "</select>";
        endif;
      endif;
      ?>
    </div>
  </div>

  <div class="card-body">



    <div class="table-responsive">
      <table class="table table-bordered" id="customerGeneralReportTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>ID</th>
            <th>CI</th>
            <th class="col-7">Cliente</th>
            <th>Acciones</th>
          </tr>
        </thead>
      </table>
    </div>

  </div>
</div>

<script src="<?= site_url() . 'assets/js/reports/customer-general-report.js' ?>"></script>