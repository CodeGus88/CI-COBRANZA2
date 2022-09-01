<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('coins_m');
    $this->load->model('reports_m');
    $this->load->library('session');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
  }

  public function index()
  {
    $data['coins'] = $this->coins_m->get();
    $data['subview'] = 'admin/reports/index';

    $this->load->view('admin/_main_layout', $data);
  }

  public function ajax_getCredits($coin_id)
  {
    $data['credits'] = $this->reports_m->get_reportLoan($this->session->userdata('user_id'), $coin_id);

    echo json_encode($data);
  }

  public function dates()
  {
    $data['coins'] = $this->coins_m->get();
    $data['subview'] = 'admin/reports/dates';
    
    $this->load->view('admin/_main_layout', $data);
  }

  public function dates_pdf($coin_id, $start_d, $end_d)
  {
    require_once APPPATH.'third_party/fpdf183/html_table.php';

    $reportCoin = $this->reports_m->get_reportCoin($coin_id);

    $pdf = new PDF();
    $pdf->AddPage('P','A4',0);
    $pdf->SetFont('Arial','B',13);
    $pdf->Ln(3);
    $pdf->Cell(0,0,utf8_decode('PRÉSTAMOS POR RANGO DE FECHAS'),0,1,'C');

    $pdf->Ln(8);
    
    $pdf->SetFont('Arial','',10);
    $html = '<table border="0">
    <tr>
    <td width="110" height="30"><b>Fecha inicial:</b></td><td width="400" height="30">'.$start_d.'</td><td width="110" height="30"><b>Tipo moneda:</b></td><td width="55" height="30">'.$reportCoin->name.'('.$reportCoin->short_name.')</td>
    </tr>
    <tr>
    <td width="110" height="30"><b>Fecha final:</b></td><td width="400" height="30">'.$end_d.'</td><td width="110" height="30"></td><td width="55" height="30"></td>
    </tr>
    </table>';

    $pdf->WriteHTML($html);
    // $reportsDates = $this->reports_m->get_reportDatesAll($coin_id,$start_d,$end_d); // para el administrador
    $reportsDates = $this->reports_m->get_reportDates($this->session->userdata('user_id'), $coin_id,$start_d,$end_d);

    $pdf->Ln(7);
    $pdf->SetFont('Arial','',10);
    $html1 = '';
    $html1 .= '<table border="1">
    <tr>
    <td width="80" height="30"><b>N'.utf8_decode("°").'Prest.</b></td><td width="100" height="30"><b>Fecha prest.</b></td><td width="120" height="30"><b>Monto prest.</b></td><td width="65" height="30"><b>Int. %</b></td><td width="65" height="30"><b>N'.utf8_decode("°").'cuot.</b></td><td width="90" height="30"><b>Modalidad</b></td><td width="100" height="30"><b>Total con Int.</b></td><td width="79" height="30"><b>Estado</b></td>
    </tr>';
    $sum_m = 0; $sum_mi = 0;
    foreach ($reportsDates as $rd) {
      $sum_m = $sum_m + $rd->credit_amount;
      $sum_mi = $sum_mi + $rd->total_int;
      $html1 .= '
    <tr>
    <td width="80" height="30">'.$rd->id.'</td><td width="100" height="30">'.$rd->date.'</td><td width="120" height="30">'.$rd->credit_amount.'</td><td width="65" height="30">'.$rd->interest_amount.'</td><td width="65" height="30">'.$rd->num_fee.'</td><td width="90" height="30">'.$rd->payment_m.'</td><td width="100" height="30">'.$rd->total_int.'</td><td width="79" height="30">'.($rd->status ? "Pendiente" : "Cancelado").'</td>
    </tr>';
    }

    $html1 .= '
    <tr>
    <td width="80" height="30"><b>Total</b></td><td width="100" height="30">-----</td><td width="120" height="30"><b>'.number_format($sum_m, 2).'</b></td><td width="65" height="30">-----</td><td width="65" height="30">-----</td><td width="90" height="30">-----</td><td width="100" height="30"><b>'.number_format($sum_mi, 2).'</b></td><td width="79" height="30">-----</td>
    </tr>';
    $html1 .= '</table>';

    $pdf->WriteHTML($html1);

    $pdf->Output('reporteFechas.pdf' , 'I');
  }

  public function customers()
  {
    // $data['customers'] = $this->reports_m->get_reportCstsAll(); // para el admministrador
    $data['customers'] = $this->reports_m->get_reportCsts($this->session->userdata('user_id'));
    $data['subview'] = 'admin/reports/customers';
    $this->load->view('admin/_main_layout', $data);
  }

  public function customer_pdf($customer_id)
  {
    require_once APPPATH.'third_party/fpdf183/html_table.php';

    // $reportCst = $this->reports_m->get_reportLCAll($customer_id); // para el administrador
    $reportCst = $this->reports_m->get_reportLC($this->session->userdata('user_id'), $customer_id);

    $pdf = new PDF();
    $pdf->AddPage('P','A4',0);
    $pdf->SetFont('Arial','B',13);
    $pdf->Ln(3);
    $pdf->Cell(0,0,utf8_decode('PRÉSTAMOS POR CLIENTE'),0,1,'C');

    $pdf->Ln(8);
  
    $pdf->SetFont('Arial','',10);

    foreach ($reportCst as $rc) {

    $html = 
    '<table border="0">
    <tr>
    <td width="120" height="30"><b>Cliente:</b></td><td width="400" height="30">'.utf8_decode($rc->customer_name)." (".$rc->ci.")".'</td><td width="120" height="30"><b>Tipo moneda:</b></td><td width="55" height="30">'.$rc->name.' ('.$rc->short_name.')</td>
    </tr>
    <tr>
    <td width="120" height="30"><b>'.utf8_decode("Crédito:").'</b></td><td width="400" height="30">'.$rc->credit_amount.'</td><td width="120" height="30"><b>'.utf8_decode("Código:").'</b></td><td width="55" height="30">'.$rc->id.'</td>
    </tr>
    <tr>
    <td width="120" height="30"><b>Nro cuotas:</b></td><td width="400" height="30">'.$rc->num_fee.'</td><td width="120" height="30"><b>Forma pago:</b></td><td width="55" height="30">'.$rc->payment_m.'</td>
    </tr>
    <tr>
    <td width="120" height="30"><b>Monto cuota:</b></td><td width="400" height="30">'.$rc->fee_amount.'</td><td width="120" height="30"><b>'.utf8_decode("Fecha crédito:").'</b></td><td width="55" height="30">'.$rc->date.'</td>
    </tr>
    <tr>
    <td width="120" height="30"><b>Asesor:</b></td><td width="400" height="30">' . utf8_decode($rc->user_name) .'</td><td width="120" height="30"><b>'.utf8_decode("Estado crédito:").'</b></td><td width="55" height="30">'.($rc->status ? "Pendiente" : "Cancelado").'</td>
    </tr>
    </table>';
    
    $pdf->WriteHTML($html);
    

    $pdf->Ln(7);
    $pdf->SetFont('Arial','',10);

    $html1 = '';
    $html1 .= '<table border="1" style="text-align:center">
    <tr>
    <td width="75" height="30"><b>Nro Cuota</b></td><td width="120" height="30"><b>Fecha pago</b></td><td width="120" height="30"><b>Total pagar</b></td><td width="120" height="30"><b>Estado</b></td>
    </tr>';

    // $loanItems = $this->reports_m->get_reportLIAll($rc->id); // Usar para el administrador
    $loanItems = $this->reports_m->get_reportLI($this->session->userdata('user_id'), $rc->id);
    foreach ($loanItems as $li) {
      $html1 .= '
    <tr>
    <td width="75" height="30">'.$li->num_quota.'</td><td width="120" height="30">'.$li->date.'</td><td width="120" height="30">'.($li->status ? $li->fee_amount : "0.00").'</td><td width="120" height="30">'.($li->status ? "Pendiente" : "Cancelado").'</td>
    </tr>';
    }

    $html1 .= '</table>';

    $pdf->WriteHTML($html1);

    $pdf->Ln(7);


    // // // Inicio garantes
    $guarantors = $this->reports_m->get_guarantors($this->session->userdata('user_id'), $rc->id);
    if($guarantors != null){
      $var = "";
      for($i = 0; $i < sizeof($guarantors); $i++){
        $separator = $i==(sizeof($guarantors)-2)?" y ":(($i==(sizeof($guarantors)-1))?".":", ");
        $var .= $guarantors[$i]->fullname . " (" . $guarantors[$i]->ci .")".$separator;
      }
      $pdf->WriteHTML('<span border-radius="10px 0px 39px 22px"><b>Garantes: </b>' . $var .'</span>');
    }
    // // Fin garantes
    }

    $pdf->Output('reporte_global_cliente.pdf', 'I');
  }

}

/* End of file Reports.php */
/* Location: ./application/controllers/admin/Reports.php */