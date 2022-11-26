<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <div>Información del rol</div>
        <div class="btn-group">
            <a class="btn btn-secondary btn-sm shadow-sm" href="<?= site_url('admin/roles/edit/') . $role->id ?>?origin=view">Editar</a>
            <?php $deleteUrl = site_url('admin/roles/delete/') . $role->id; ?>
            <button class="btn btn-danger btn-sm shadow-sm" onclick="deleteConfirmation('CONFIRMACIÓN', '¿Realmente desea eliminar este rol?', '<?= $deleteUrl ?>')">Eliminar</a>
        </div>
    </div>
    <div class="card-body">
        <?php if (validation_errors()) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo validation_errors('<li>', '</li>'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="false">&times;</span>
                </button>
            </div>
        <?php } ?>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label class="small mb-1">Nombre del rol</label>
                <p class="form-control"><?= $role->name ?? '' ?></p>
            </div>
            <div class="form-group col-md-12">
                <label class="small mb-1">Descripción</label>
                <p class="form-control"><?= $role->description ?? '' ?></p>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12 col-md-12 table-responsive">
                <table class="table table-bordered table-striped table-hover" id="permissions" width="100%" cellspacing="0">
                    <?php $colums = 1; ?>
                    <thead>
                        <tr>
                            <th colspan="<?= $colums ?>">Permisos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($permissions) :
                            for ($i = 0; $i < sizeof($permissions); $i++) :
                        ?>
                                <?php
                                for ($j = 0; $j < $colums; $j++) :
                                    if ($i + $j < sizeof($permissions)) :
                                ?>
                                        <td class="col-<? $colums / 12 ?> col-lg-<? $colums / 12 ?>">
                                            <div class="form-check">
                                                <label class="form-check-label small" for="flexCheckDefault" title="<?= $permissions[$i + $j]->name ?>">
                                                    <?= $permissions[$i + $j]->name ?>
                                                </label>
                                            </div>
                                        </td>
                                <?php
                                    endif;
                                endfor;
                                $i += $colums - 1;
                                ?>

                                </tr>
                        <?php
                            endfor;
                        endif
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>