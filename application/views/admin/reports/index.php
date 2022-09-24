<div class="card shadow mb-4">
  <div class="card-header d-flex align-items-center justify-content-between py-3">
    <h6 class="m-0 font-weight-bold text-primary">Resumen general de préstamos</h6>
    <div>
      <?php 
      if(isset($users)) : if(sizeof($users) > 0) :
        echo "<select class='custom-select-sm btn-outline-secondary' onchange='location = this.value;'>";
        $url = site_url('admin/reports');
        $selected = ($selected_user_id == 0) ? 'selected' : '';
        echo "<option value='$url' $selected>TODOS</option>";
        foreach($users as $user) :
          $url = site_url("admin/reports/index/$user->id");
          $selected = ($user->id==$selected_user_id)? 'selected' : '';
          $user_name = "$user->academic_degree $user->first_name $user->last_name";
          echo "<option value='$url' $selected>$user_name</option>";
        endforeach;
        echo "</select>";
      endif; endif;
      ?>
      <?php $title = isset($selected_user)?"RESUMEN DE PRÉSTAMOS - $selected_user->user_name":'RESUMEN GENERAL DE PRÉSTAMOS'; ?>
      <a class="d-sm-inline-block btn btn-sm btn-success shadow-sm" href="#" onclick="printElementById('imp1', '<?=$title?>');"><i class="fas fa-print fa-sm"></i> Imprimir</a>
    </div>
    
  </div>
  <div class="card-body">

    <div class="form-row">
      <div class="form-group col-4">

        <label class="small mb-1" for="exampleFormControlSelect2">Tipo de moneda</label>
        <select class="form-control" id="coin_type" name="coin_type">
          <?php foreach ($coins as $c): ?>
            <option <?php if(strtolower($c->name)=='bolivianos') echo 'selected' ?> value="<?php echo $c->id ?>" data-symbol="<?php echo $c->short_name ?>"><?php echo $c->name.' ('.strtoupper($c->short_name).')' ?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>

    <div class="table-responsive" id="imp1">
      <table class="table" width="100%" cellspacing="0" >
        <thead class="thead-dark">
          <tr>
            <th>Descripción</th>
            <th class="text-right">Cantidad</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Total crédito</td>
            <td class="text-right" id="cr">0</td>
          </tr>
          <tr>
            <td>Total crédito con interés</td>
            <td class="text-right" id="cr_interest">0</td>
          </tr>
          <tr>
            <td>Total crédito cancelado con interés</td>
            <td class="text-right" id="cr_interestPaid">0</td>
          </tr>
          <tr>
            <td>Total crédito por cobrar con interés</td>
            <td class="text-right" id="cr_interestPay">0</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- paso de varables a javascript -->
<?php if(isset($selected_user_id)) : ?>
  <script>const SELECTED_USER_ID = <?=$selected_user_id?>;</script>
<?php else : ?>
  <script>const SELECTED_USER_ID = 0;</script>
<?php endif ;?>

<?php echo "<script>window.onload = function () { loadGeneralReport(); }</script>" ?>