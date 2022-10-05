<!-- <div class="modal-dialog"> -->
<div class="modal-dialog modal-lg">

  <div class="modal-content">

    <div class="d-flex flex-row-reverse col-md-12" style="padding-top:10px;">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="padding-left:10px;"><i class="fas fa-times fa-sm"></i></button>
      <button type="button" class="close" onclick="printElementById('printable', 'COBROS PRÓXMIMOS')"><i class="fas fa-print fa-sm"></i></button>
    </div>
    <div id="printable">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">
          <?php 
          $quotes = ($items!=null)?sizeof($items): "0";
          echo "Planificación de cobros para la semana (". $quotes." cuotas)" 
          ?>
        </h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive" id="table">
            <h6 class="h6">Montos a cobrar:</h6>
              <?php if(isset($payables)) :?>
                <?php foreach($payables as $payable) :?>
                  <span class="btn btn-light"> </b><?="$payable->total $payable->name"?></span>
                <?php endforeach?>
                <br>
              <?php endif?>
              <?php if ($items != null) : 
                echo '<small>En la lista se muestran las cuotas con moras y las cuotas cobrables en los próximos 7 días</small>';
              ?>

              <div class="table-responsive">
                <table class="table table-striped table-condensed">
                  <thead>
                    <tr class="active">
                      <th>CI</th>
                      <th class="col-xs-2">Cliente</th>
                      <th class="col-xs-2">Monto</th>
                      <th class="col-xs-2 text-center">Fecha</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($items) {
                        $i = 0;
                        foreach ($items as $item) {
                          $payed = ($item->payed != null)?$item->payed:0;
                          $mount = $item->fee_amount - $payed;
                          echo '<tr title="Asesor: '.$item->user_name.' ">';
                            echo '<td>' . $item->dni. '</td>';
                            echo '<td>' . $item->customer_name . '</td>';
                            echo "<td>$mount $item->coin_short_name</td>";
                            echo '<td>' . $item->date . '</td>';
                            $pay_url = '#';// site_url('admin/payments/edit');
                            if( $item->date == date("Y-m-d") ){
                              echo '<td><center><a class="btn btn-sm btn-warning" href="'. $pay_url .'">' . 'HOY' . '</a></center></td>';
                            }elseif($item->date < date("Y-m-d")){
                              echo '<td><center><a class="btn btn-sm btn-danger" href="'. $pay_url .'">' . 'MORA' . '</a></center></td>';
                            }else{
                              echo '<td><center><a class="btn btn-sm btn-success" href="'. $pay_url .'">' . 'CERCA' . '</a></center></td>';
                            }
                            
                          echo '</tr>';
                        }
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>