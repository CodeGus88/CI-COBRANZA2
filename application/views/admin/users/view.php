<?php if ($user != null) : ?>
    <div class="card shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <h6 class="m-0 font-weight-bold text-primary" id="user_name">USUARIO</h6>
            <div class="btn-group">
                <!-- botones de encabezado -->
            </div>
        </div>
        <div class="card-body">
            <div class=" col-12 text-center">
                <h5 class="h5">DETALLES</h5>
            </div>
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
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between py-3">
                    <h6 class="h6">Datos del usuario</h6>
                    <div class="btn-group">
                        <a class="btn btn-secondary btn-sm shadow-sm" href="<?= site_url('admin/users/edit/') . $user->id ?>?origin=view">Editar</a>
                        <?php $deleteUrl = site_url('admin/users/delete/') . $user->id; ?>
                        <button class="btn btn-danger btn-sm shadow-sm" onclick="deleteConfirmation('CONFIRMACIÓN', '¿Realmente desea eliminar este usuario?', '<?=$deleteUrl?>')">Eliminar</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="small mb-1">Identificador</label>
                            <input class="form-control" id="id" type="text" value="<?= $user->id ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small mb-1">Nombre</label>
                            <input class="form-control" type="text" value="<?= $user->first_name ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small mb-1">Apellidos</label>
                            <input class="form-control" type="text" value="<?= $user->last_name ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small mb-1">Email</label>
                            <input class="form-control" type="text" value="<?= $user->email ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small mb-1">Grado</label>
                            <input class="form-control" type="text" value="<?= $user->academic_degree ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small mb-1">Avatar</label>
                            <div class="form-control py-0 text-justify">
                                <img src="<?= site_url('assets/img/avatars/') . $user->avatar ?>" alt="Avatar" width="35" height="35">
                                <span><?= $user->avatar ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="roles" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ROLES</th>
                            <th>PERMISOS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rolesPermissions as  $item) :
                            $rowSpan = sizeof($item->permissions) == 0 ? 1 : sizeof($item->permissions);
                        ?>
                            <tr class="text-center">
                                <td class="align-middle"><input class="btn btn-outline-secondary" value="<?= $item->name ?>" readonly></td>
                                <td class="align-middle">
                                    <?php foreach ($item->permissions as $subItem) : ?>
                                        <input class="btn btn-outline-secondary" value="<?= $subItem->name ?>" ? readonly>
                                    <?php endforeach ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <br>
        </div>
    <?php else : ?>
        <script>
            alert('No existen datos');
        </script>
    <?php endif ?>
    <!-- <div class="modal fade" id="myModal" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"></div> -->