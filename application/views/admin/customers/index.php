<div class="card shadow mb-4">
  <div class="card-header d-flex align-items-center justify-content-between py-3">
    <h6 class="m-0 font-weight-bold text-primary">Lista de clientes</h6>
    <div>
        <?php
        if (isset($users)) :
          if (sizeof($users) > 0) :
            echo '<select onchange="location = this.value;">';
            $url = site_url('admin/customers');
            $selected = (0 == $user->id) ? 'selected' : '';
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
      <!-- </div> -->
      <!-- <div> -->
        <?php if ($CUSTOMER_CREATE || $AUTHOR_CUSTOMER_CREATE) : ?>
          <a class="d-sm-inline-block btn btn-sm btn-success shadow-sm" href="<?php echo site_url('admin/customers/edit'); ?>"><i class="fas fa-plus-circle fa-sm"></i> Nuevo cliente</a>
        <?php endif ?>
      <!-- </div> -->
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
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Género</th>
            <th>Celular</th>
            <th>Empresa</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($customers)) : foreach ($customers as $ct) : ?>
              <tr>
                <td><?php echo $ct->dni ?></td>
                <td><?php echo $ct->first_name ?></td>
                <td><?php echo $ct->last_name ?></td>
                <td><?php echo $ct->gender ?></td>
                <td><?php echo $ct->mobile ?></td>
                <td><?php echo $ct->company ?></td>
                <td class="align-self-center">
                  <button type="button" class="btn btn-sm <?php echo $ct->loan_status ? 'btn-outline-danger' : 'btn-outline-success' ?> status-check"><?php echo $ct->loan_status ? 'Con Crédito' : 'Sin Crédito' ?></button>
                </td>
                <td class="align-self-center" style="vertical-align: middle">
                  <div class="btn-group">
                    <?php if ($CUSTOMER_UPDATE || ($AUTHOR_CUSTOMER_UPDATE && $ct->user_id == $this->session->userdata('user_id'))) : ?>
                      <a href="<?php echo site_url('admin/customers/edit/' . $ct->id); ?>" class="btn btn-sm btn-info shadow-sm">Editar</a>
                    <?php endif ?>
                    <?php if ($CUSTOMER_DELETE || ($AUTHOR_CUSTOMER_DELETE && $ct->user_id == $this->session->userdata('user_id'))) : ?>
                      <a onclick="return deleteConfirm(<?= $ct->id ?>, '¿Estas seguro?','¡No podrás revertir esto!  Eliminar cliente: (<?php echo $ct->dni ?>) <?php echo $ct->first_name . ' ' . $ct->last_name ?>')" class="btn btn-sm btn-danger shadow-sm">
                        Eliminar
                        <a href="<?php echo site_url('admin/customers/delete/' . $ct->id); ?>" id="delete<?php echo $ct->id ?>" hidden></a>
                      </a>
                    <?php endif ?>
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