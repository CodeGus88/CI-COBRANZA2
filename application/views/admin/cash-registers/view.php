<div class="card shadow mb-4">
    <div class="card-header d-flex align-items-center justify-content-between py-3">
        <h6 class="m-0 font-weight-bold text-primary" id="cash_register_name"><?= $cash_register->name ?? 'undefined' ?></h6>
    </div>
    <?php if (isset($cash_register)) : ?>

        <div class="card-body">
            <div class=" col-12 text-center">
                <h5 class="h5">DETALLES</h5>
            </div>
            <div class="card">
                <div class="card-header">
                    <h6 class="h6">Datos técnicos</h6>
                </div>

                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="small mb-1">Usuario</label>
                            <input class="form-control" type="text" name="dni" value="<?= $cash_register->user_name ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small mb-1">Fecha de apertura</label>
                            <input class="form-control" style="text-transform:uppercase" type="text" name="first_name" value="<?= $cash_register->opening_date ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small mb-1">Fecha de cierre</label>
                            <input class="form-control" style="text-transform:uppercase" type="text" name="last_name" value="<?= $cash_register->closing_date ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small mb-1">Identificador</label>
                            <input class="form-control" id="id" style="text-transform:uppercase" type="text" name="last_name" value="<?= $cash_register->id ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small mb-1">Tipo de moneda</label>
                            <input class="form-control" style="text-transform:uppercase" type="text" name="last_name" value="<?= $cash_register->coin_name ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="small mb-1">Estado</label>
                            <button class="form-control <?= $cash_register->status ? 'btn-success' : 'btn-warning' ?>" style="text-transform:uppercase" type="text" name="last_name"><?= $cash_register->status ? "Abierto" : "Cerrado" ?></button>
                        </div>
                    </div>

                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h6 class="h6">Entradas manuales</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="manual-inputs" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="col-1">ID</th>
                                    <th class="col-2">Monto</th>
                                    <th class="col-6">Descripción</th>
                                    <th class="col-3">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h6 class="h6">Entradas por pagos</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="document-payment-inputs" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="col-1">ID</th>
                                    <th class="col-6">Cliente</th>
                                    <th class="col-2">Monto</th>
                                    <th class="col-3">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h6 class="h6">Salidas manuales</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="manual-outputs" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="col-1">ID</th>
                                    <th class="col-2">Monto</th>
                                    <th class="col-6">Descripción</th>
                                    <th class="col-3">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h6 class="h6">Salidas por préstamos</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="loan-outputs" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="col-1">ID</th>
                                    <th class="col-6">Cliente</th>
                                    <th class="col-2">Monto</th>
                                    <th class="col-3">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h6 class="h6">Resumen general</h6>
                </div>
                <div class="card-body ">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col"><b>Descripción</b></th>
                                    <th scope="col">
                                        <d>Manual</b>
                                    </th>
                                    <th scope="col">Operación</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Entradas</th>
                                    <td><?= number_format($cash_register->manual_inputs_amount, 2) ?></td>
                                    <td><?= number_format($cash_register->document_payment_inputs_amount, 2) ?></td>
                                    <td><?= number_format($cash_register->manual_inputs_amount + $cash_register->document_payment_inputs_amount, 2) ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Salidas</th>
                                    <td><?= number_format($cash_register->manual_outputs_amount, 2) ?></td>
                                    <td><?= number_format($cash_register->loan_outputs_amount, 2) ?></td>
                                    <td><?= number_format($cash_register->manual_outputs_amount + $cash_register->loan_outputs_amount, 2) ?></td>
                                </tr>
                                <tr>
                                    <?php
                                    $manualTotal = number_format($cash_register->manual_inputs_amount - $cash_register->manual_outputs_amount, 2);
                                    $operationTotal = number_format($cash_register->document_payment_inputs_amount - $cash_register->loan_outputs_amount, 2);
                                    $total = number_format($cash_register->manual_inputs_amount - $cash_register->manual_outputs_amount +
                                        $cash_register->document_payment_inputs_amount - $cash_register->loan_outputs_amount, 2);
                                    ?>
                                    <th scope="row">Total</th>
                                    <td><b><?= $manualTotal ?></b></td>
                                    <td><b><?= $operationTotal ?></b></td>
                                    <td ><b><?= $total ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>
<script src="<?= site_url() . 'assets/js/cash-registers/view.js' ?>"></script>