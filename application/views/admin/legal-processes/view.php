
<link href="<?php echo site_url() ?>assets/css/image-modal-style.css" rel="stylesheet">

<div class="card shadow mb-4">
    <div class="card-header py-3">Proceso legal</div>
    <div class="card-body">
        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= validation_errors('<li>', '</li>') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif ?>

        <div class="form-row">
            <div class="form-group col-12">
                <label class="small mb-1" for="customer_id">Cliente</label>
                <p class="form-control"><?= $legal_process->customer ?></p>

            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12">
                <label class="small mb-1" for="start_date">Fecha de inicio</label>
                <p class="form-control"><?= $legal_process->start_date ?></p>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-12">
                <label class="small mb-1" for="observations">Observaciones</label>
                <p><?= $legal_process->observations ?></p>
            </div>
        </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th>Imágenes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>
                            <div class="form-row text-center">
                                
                            <?php $i = 1; foreach ($legal_process->files as $file) : ?>
                                <img id="img<?=$i?>" src="<?= site_url('uploads/' . $file->name) ?>" class="img-fluid col-lg-3 col-sm-12 col-md-4 mb-2 btn" alt="<?= $file->name ?>">
                                <?php $i++; endforeach ?>
                            </div>
                            <script>
                                i = <?=$i -1?>;
                            </script>
                        </th>
                    </tr>
                </tbody>
            </table>

    </div>
</div>

<!-- The Modal -->
<div id="modal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img">
  <div id="caption"></div>
</div>


<script src="<?= site_url('assets/js/legal-processes/view.js') ?>"></script>