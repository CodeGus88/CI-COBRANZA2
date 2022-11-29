<div class="card shadow mb-4">
  <div class="card-header d-flex align-items-center justify-content-between py-3">
    <h6 class="m-0 font-weight-bold text-primary">Lista de clientes</h6>
    <div>
      <?php
      if (isset($users)) :
        if (sizeof($users) > 0) :
          echo '<select class="custom-select-sm btn-outline-secondary" onchange="location = this.value;">';
          $url = site_url('admin/customers/index/all');
          $selected = ($user->id == 'all') ? 'selected' : '';
          echo "<option value='$url' $selected>TODOS</option>";
          foreach ($users as $user) :
            $url = site_url("admin/customers/index/$user->id");
            $selected = ($selected_user_id == $user->id) ? 'selected' : '';
            echo "<option value='$url' $selected>$user->academic_degree $user->first_name $user->last_name </option>";
          endforeach;
          echo "</select>";
        endif;
      endif;
      ?>
      <?php if ($CUSTOMER_CREATE || $AUTHOR_CUSTOMER_CREATE) : ?>
        <a class="d-sm-inline-block btn btn-sm btn-success shadow-sm" href="<?php echo site_url('admin/customers/edit'); ?>"><i class="fas fa-plus-circle fa-sm"></i> Nuevo cliente</a>
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
            <th class="col-1">CI</th>
            <th class="col-5">Nombre completo</th>
            <th class="col-1">Género</th>
            <th class="col-1">Celular</th>
            <th class="col-1">Empresa</th>
            <th class="col-2">Estado</th>
            <th class="col-1">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($customers)) : foreach ($customers as $ct) : ?>
              <tr>
                <td><?php echo $ct->ci ?></td>
                <td><?php echo $ct->first_name . " " . $ct->last_name ?></td>
                <td><?php echo $ct->gender ?></td>
                <td><?php echo $ct->mobile ?></td>
                <td><?php echo $ct->company ?></td>
                <td class="align-self-center">
                  <button type="button" class="btn btn-sm <?php echo $ct->loan_status ? 'btn-outline-danger' : 'btn-outline-success' ?> status-check"><?php echo $ct->loan_status ? 'Con Crédito' : 'Sin Crédito' ?></button>
                </td>
                <td>
                  <div class="container-fluid">
                    <div class="row">
                      <?php if ($CUSTOMER_UPDATE || ($AUTHOR_CUSTOMER_UPDATE && $ct->user_id == $this->session->userdata('user_id'))) : ?>
                        <a href="<?php echo site_url('admin/customers/edit/' . $ct->id); ?>" class="btn btn-warning btn-circle btn-sm">
                          <i class="fas fa-edit fa-sm" title="Editar"></i>
                        </a>
                      <?php endif ?>
                      <?php if ($CUSTOMER_DELETE || ($AUTHOR_CUSTOMER_DELETE && $ct->user_id == $this->session->userdata('user_id'))) : ?>
                        <a onclick="return deleteConfirm(<?= $ct->id ?>, '¿Estas seguro?','¡No podrás revertir esto!  Eliminar cliente: (<?php echo $ct->ci ?>) <?php echo $ct->first_name . ' ' . $ct->last_name ?>')" class="btn btn-danger btn-circle btn-sm">
                          <i class="fas fa-trash" title="Eliminar"></i>
                          <a href="<?php echo site_url('admin/customers/delete/' . $ct->id); ?>" id="delete<?php echo $ct->id ?>" hidden></a>
                        </a>
                      <?php endif ?>
                    </div>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="7" class="text-center">No existen clientes para mostrar</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>