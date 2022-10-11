<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . "/tools/UserPermission.php");

class Reports extends CI_Controller
{

  private $permission;
  private $user_id;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('coins_m');
    $this->load->model('reports_m');
    $this->load->model('permission_m');
    $this->load->library('session');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
    $this->user_id = $this->session->userdata('user_id');
    $this->permission = new Permission($this->permission_m, $this->user_id);
  }

  // public function index($user_id = 0)
  // {
  //   $LOAN_READ = $this->permission->getPermission([LOAN_READ], FALSE);
  //   $AUTHOR_LOAN_READ = $this->permission->getPermission([AUTHOR_LOAN_READ], FALSE);
  //   $this->permission->redirectIfFalse(($AUTHOR_LOAN_READ || $LOAN_READ), TRUE);
  //   if ($LOAN_READ) {
  //     $user_id = (!is_numeric($user_id)) ? 0 : $user_id;
  //     $data['users'] = $this->db->get('users')->result();
  //     $data['selected_user_id'] = $user_id;
  //     $data['selected_user'] = $this->reports_m->getUser($user_id);
  //   } else {
  //     $data['selected_user'] = $this->reports_m->getUser($this->user_id);
  //   }
  //   $data['coins'] = $this->coins_m->get();
  //   $data['subview'] = 'admin/reports/index';
  //   $this->load->view('admin/_main_layout', $data);
  // }

  public function index()
  {
    $LOAN_READ = $this->permission->getPermission([LOAN_READ], FALSE);
    $AUTHOR_LOAN_READ = $this->permission->getPermission([AUTHOR_LOAN_READ], FALSE);
    $this->permission->redirectIfFalse(($AUTHOR_LOAN_READ || $LOAN_READ), TRUE);
    if ($LOAN_READ) {
      $data['users'] = $this->db->get('users')->result();
    } else {
      $data['selected_user'] = $this->reports_m->getUser($this->user_id);
    }
    $data['coins'] = $this->coins_m->get();
    $data['subview'] = 'admin/reports/index';
    $this->load->view('admin/_main_layout', $data);
  }

  public function ajax_getCredits($coin_id, $start_d, $end_d, $user_id)
  {
    if ($this->permission->getPermission([LOAN_READ], FALSE)) {
      if ($user_id == 'all') {
        $data['credits'] = $this->reports_m->get_reportLoanAll($coin_id, $start_d, $end_d);
        $all_users = new stdClass();
        $all_users->user_name = $user_id;
        $data['selected_user'] =  $all_users;
      } elseif(is_numeric($user_id)) {
        $data['credits'] = $this->reports_m->get_reportLoan($user_id, $coin_id, $start_d, $end_d);
        $data['selected_user'] = $this->reports_m->getUser($user_id);
      }
    } else if ($this->permission->getPermission([AUTHOR_LOAN_READ], FALSE)) {
      $data['credits'] = $this->reports_m->get_reportLoan($this->user_id, $coin_id, $start_d, $end_d);
      $data['selected_user'] = $this->reports_m->getUser($this->user_id);
    }
    echo json_encode($data);
  }

  public function dates()
  {
    $AUTHOR_LOAN_READ = $this->permission->getPermission([AUTHOR_LOAN_READ], FALSE);
    $LOAN_READ = $this->permission->getPermission([LOAN_READ], FALSE);
    $this->permission->redirectIfFalse([$AUTHOR_LOAN_READ || $LOAN_READ], TRUE);
    if ($LOAN_READ) $data['users'] = $this->db->get('users')->result();
    else $data['user_id'] = $this->session->userdata('user_id');
    $data['coins'] = $this->coins_m->get();
    $data['subview'] = 'admin/reports/dates';
    $this->load->view('admin/_main_layout', $data);
  }

  public function dates_pdf($coin_id, $start_d, $end_d, $user_id = 0)
  {
    require_once APPPATH . 'third_party/fpdf183/html_table.php';
    $reportCoin = $this->reports_m->get_reportCoin($coin_id);

    if ($this->permission->getPermission([LOAN_READ], FALSE)) {
      if ($user_id == 0){
        $reportsDates = $this->reports_m->get_reportDatesAll($coin_id, $start_d, $end_d);
        $user_name = "TODOS";
      }elseif (is_numeric($user_id)) {
        $reportsDates = $this->reports_m->get_reportDates($user_id, $coin_id, $start_d, $end_d);
        $query = $this->reports_m->getUser($user_id);
        $user_name = isset($query) ? $query->user_name : "...";
      } else{
        $reportsDates = [];
        $user_name = '...';
      }
    } else if ($this->permission->getPermission([AUTHOR_LOAN_READ], FALSE)) {
      $reportsDates = $this->reports_m->get_reportDates($this->user_id, $coin_id, $start_d, $end_d);
      $query = $this->reports_m->getUser($user_id);
      $user_name = isset($query) ? $query->user_name : "...";
    } else {
      $reportsDates = [];
      $user_name = '...';
    }

    $pdf = new PDF();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Ln(3);
    $pdf->Cell(0, 0, utf8_decode('PRÉSTAMOS POR RANGO DE FECHAS'), 0, 1, 'C');

    $pdf->Ln(8);

    $pdf->SetFont('Arial', '', 10);

    $html = '<table border="0">
    <tr>
    <td width="110" height="30"><b>Tipo moneda:</b></td><td width="400" height="30">' . $reportCoin->name. ' (' . $reportCoin->short_name . ')</td>  <td width="110" height="30"><b>Fecha inicial:</b></td><td width="50" height="30">' . $start_d . '</td>
    </tr>
    <tr>
    <td width="110" height="30"><b>Usuario:</b></td><td width="400" height="30">' . trim($user_name) . '</td>  <td width="110" height="30"><b>Fecha final:</b></td><td width="50" height="30">' . $end_d . '</td>
    </tr>
    </table>';

    $pdf->WriteHTML(utf8_decode($html));

    $pdf->Ln(7);
    $pdf->SetFont('Arial', '', 10);
    $html1 = '';
    $html1 .= '<table border="1">
    <tr>
    <td width="80" height="30"><b>N° Prest.</b></td><td width="100" height="30"><b>Fecha prest.</b></td><td width="120" height="30"><b>Monto prest.</b></td><td width="65" height="30"><b>Int. %</b></td><td width="65" height="30"><b>N° cuot.</b></td><td width="90" height="30"><b>Modalidad</b></td><td width="100" height="30"><b>Total con Int.</b></td><td width="79" height="30"><b>Estado</b></td>
    </tr>';
    $sum_m = 0;
    $sum_mi = 0;
    foreach ($reportsDates as $rd) {
      $sum_m = $sum_m + $rd->credit_amount;
      $sum_mi = $sum_mi + $rd->total_int;
      $html1 .= '
    <tr>
    <td width="80" height="30">' . $rd->id . '</td><td width="100" height="30">' . $rd->date . '</td><td width="120" height="30">' . $rd->credit_amount . '</td><td width="65" height="30">' . $rd->interest_amount . '</td><td width="65" height="30">' . $rd->num_fee . '</td><td width="90" height="30">' . $rd->payment_m . '</td><td width="100" height="30">' . $rd->total_int . '</td><td width="79" height="30">' . ($rd->status ? "Pendiente" : "Cancelado") . '</td>
    </tr>';
    }

    $html1 .= '
    <tr>
    <td width="80" height="30"><b>Total</b></td><td width="100" height="30">-----</td><td width="120" height="30"><b>' . number_format($sum_m, 2) . '</b></td><td width="65" height="30">-----</td><td width="65" height="30">-----</td><td width="90" height="30">-----</td><td width="100" height="30"><b>' . number_format($sum_mi, 2) . '</b></td><td width="79" height="30">-----</td>
    </tr>';
    $html1 .= '</table>';

    $pdf->WriteHTML(utf8_decode($html1));

    $pdf->Output('reporteFechas.pdf', 'I');
  }

  public function customers($user_id = 0)
  {
    if ($this->permission->getPermissionX([LOAN_READ, LOAN_ITEM_READ], FALSE)) {
      $data['users'] = $this->db->order_by('id')->get('users')->result();
      if ($user_id == 0) {
        $data['customers'] = $this->reports_m->get_reportCstsAll();
      } else {
        $data['customers'] = $this->reports_m->get_reportCsts($user_id);
        $data['selected_user_id'] = $user_id;
      }
    } else if ($this->permission->getPermissionX([AUTHOR_LOAN_READ, AUTHOR_LOAN_ITEM_READ], FALSE)) {
      $data['customers'] = $this->reports_m->get_reportCsts($this->session->userdata('user_id'));
    } else {
      $this->permission->getPermissionX([], TRUE);
    }
    $data['subview'] = 'admin/reports/customers';
    $this->load->view('admin/_main_layout', $data);
  }

  public function customer_pdf($customer_id)
  {
    require_once APPPATH . 'third_party/fpdf183/html_table.php';

    $reportCst = [];
    if ($this->permission->getPermissionX([LOAN_READ, LOAN_ITEM_READ], FALSE)) {
      $reportCst = $this->reports_m->get_reportLCAll($customer_id);
    } else if ($this->permission->getPermission([AUTHOR_LOAN_READ, AUTHOR_LOAN_ITEM_READ], FALSE)) {
      $reportCst = $this->reports_m->get_reportLC($this->user_id, $customer_id);
    } else {
      $this->permission->getPermissionX([], TRUE);
    }

    $pdf = new PDF();
    $pdf->AddPage('P', 'A4', 0);
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Ln(3);
    $pdf->Cell(0, 0, utf8_decode('PRÉSTAMOS POR CLIENTE'), 0, 1, 'C');

    $pdf->Ln(8);

    $pdf->SetFont('Arial', '', 10);

    foreach ($reportCst as $rc) {

      $html =
        '<table border="0">
    <tr>
    <td width="100" height="30"><b>Cliente:</b></td><td width="600" height="30">' . $rc->customer_name . '</td>
    </tr>
    <tr>
    <td width="100" height="30"><b>CI:</b></td><td width="400" height="30">' . $rc->ci .'</td><td width="100" height="30" style="background-color:white"><b>Moneda:</b></td><td width="100" height="30">' . $rc->name . ' (' . $rc->short_name . ')</td>
    </tr>
    <tr>
    <td width="100" height="30"><b>Crédito:</b></td><td width="400" height="30">' . $rc->credit_amount . '</td><td width="100" height="30"><b>Código:</b></td><td width="100" height="30">' . $rc->id . '</td>
    </tr>
    <tr>
    <td width="100" height="30"><b>Nro cuotas:</b></td><td width="400" height="30">' . $rc->num_fee . '</td><td width="100" height="30"><b>Forma pago:</b></td><td width="100" height="30">' . $rc->payment_m . '</td>
    </tr>
    <tr>
    <td width="100" height="30"><b>Monto cuota:</b></td><td width="400" height="30">' . $rc->fee_amount . '</td><td width="100" height="30"><b>Fecha:</b></td><td width="100" height="30">' . $rc->date . '</td>
    </tr>
    <tr>
    <td width="100" height="30"><b>Asesor:</b></td><td width="400" height="30">' . $rc->user_name. '</td><td width="100" height="30"><b>Estado:</b></td><td width="100" height="30">' . ($rc->status ? "Pendiente" : "Cancelado") . '</td>
    </tr>
    </table>';

      $pdf->WriteHTML(utf8_decode($html));

      $pdf->Ln(7);
      $pdf->SetFont('Arial', '', 10);
      $tableTab = "         ";

      $html1 = '<table border="1">';
      $html1 .= $tableTab . '<tr><td width="75" height="30"><b>Nro Cuota</b></td><td width="150" height="30"><b>Fecha pago</b></td><td width="120" height="30"><b>Cuota</b></td><td width="120" height="30"><b>Pagado</b></td><td width="120" height="30"><b>Por pagar</b></td><td width="120" height="30"><b>Estado</b></td></tr>';

      if ($this->permission->getPermission([LOAN_ITEM_READ], FALSE)) {
        $loanItems = $this->reports_m->get_reportLIAll($rc->id);
      } elseif ($this->permission->getPermission([AUTHOR_LOAN_ITEM_READ], FALSE)) {
        $loanItems = $this->reports_m->get_reportLI($this->session->userdata('user_id'), $rc->id);
      }

      foreach ($loanItems as $li) {
        $defaultContent = '-';
        if($li->status == FALSE && $li->payed == 0)
          $li->payed = $defaultContent;
        $payable = ( $li->payed == $defaultContent)?'-':number_format($li->fee_amount - $li->payed, 2);
        $html1 .= $tableTab . '<tr><td width="75" height="30">' . $li->num_quota . '</td><td width="150" height="30">' . $li->date . '</td><td width="120" height="30">' . $li->fee_amount . '</td><td width="120" height="30">' . $li->payed . '</td><td width="120" height="30">' . $payable . '</td><td width="120" height="30">' . ($li->status ? "Pendiente" : "Cancelado") . '</td></tr>';
      }

      $html1 .= '</table>';
      $pdf->WriteHTML(utf8_decode($html1));

      $pdf->Ln(7);

      // // // Inicio garantes
      if ($this->permission->getPermissionX([LOAN_READ, LOAN_ITEM_READ], FALSE)) {
        $guarantors = $this->reports_m->get_guarantorsAll($rc->id);
      } elseif ($this->permission->getPermissionX([AUTHOR_LOAN_READ, AUTHOR_LOAN_ITEM_READ], TRUE)) {
        $guarantors = $this->reports_m->get_guarantors($this->user_id, $rc->id);
      }

      if ($guarantors != null) {
        $var = "";
        for ($i = 0; $i < sizeof($guarantors); $i++) {
          $separator = $i == (sizeof($guarantors) - 2) ? " y " : (($i == (sizeof($guarantors) - 1)) ? "." : ", ");
          $var .= $guarantors[$i]->fullname . " (" . $guarantors[$i]->ci . ")" . $separator;
        }
        $pdf->Cell(7);
        $pdf->WriteHTML('<span border-radius="10px 0px 39px 22px"><b>Garantes: </b>' . $var . '</span>');
      }
      // Fin garantes
    }

    $pdf->Output('reporte_global_cliente.pdf', 'I');
  }
}

/* End of file Reports.php */
/* Location: ./application/controllers/admin/Reports.php */