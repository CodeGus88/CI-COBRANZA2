<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . "/tools/UserPermission.php");

class Loans extends CI_Controller
{

  private $permission;
  private $user_id;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('loans_m');
    $this->load->model('customers_m');
    $this->load->model('permission_m');
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
    $this->user_id = $this->session->userdata('user_id');
    $this->permission = new Permission($this->permission_m, $this->user_id);
  }

  public function index()
  {
    $data[LOAN_CREATE] = $this->permission->getPermission([LOAN_CREATE], FALSE);
    $data[LOAN_ITEM_CREATE] = $this->permission->getPermission([LOAN_ITEM_CREATE], FALSE);
    $data[AUTHOR_LOAN_CREATE] = $this->permission->getPermission([AUTHOR_LOAN_CREATE], FALSE);
    $data[AUTHOR_LOAN_ITEM_CREATE] = $this->permission->getPermission([AUTHOR_LOAN_ITEM_CREATE], FALSE);
    $data[LOAN_ITEM_READ] = $this->permission->getPermission([LOAN_ITEM_READ], FALSE);
    $data[AUTHOR_LOAN_ITEM_READ] = $this->permission->getPermission([AUTHOR_LOAN_ITEM_READ], FALSE);
    $data['loans'] = array();
    if ($this->permission->getPermission([LOAN_READ], FALSE)) {
      $data['loans'] = $this->loans_m->getLoansAll();
    } elseif ($this->permission->getPermission([AUTHOR_LOAN_READ], FALSE)) {
      $data['loans'] = $this->loans_m->getLoans($this->user_id);
    }
    $data['subview'] = 'admin/loans/index';
    $this->load->view('admin/_main_layout', $data);
  }

  public function edit()
  {
    if (
      $this->permission->getPermissionX([AUTHOR_LOAN_CREATE, AUTHOR_LOAN_ITEM_CREATE], FALSE) ||
      $this->permission->getPermissionX([LOAN_CREATE, LOAN_ITEM_CREATE], FALSE)
    ) {
      $data['coins'] = $this->loans_m->getCoins();
      if ($this->permission->getPermissionX([LOAN_CREATE, LOAN_ITEM_CREATE], FALSE)) {
        $data['customers'] = $this->loans_m->getCustomersAll();
      } else {
        $data['customers'] = $this->loans_m->getCustomers($this->user_id);
      }

      $rules = $this->loans_m->loan_rules;

      $this->form_validation->set_rules($rules);

      if ($this->form_validation->run() == TRUE) {
        if ($this->input->post('payment_m') == 'diario')
          $p = 'P1D';
        if ($this->input->post('payment_m') == 'semanal')
          $p = 'P7D';
        if ($this->input->post('payment_m') == 'quincenal')
          $p = 'P15D';
        if ($this->input->post('payment_m') == 'mensual')
          $p = 'P1M';
        // definir periodo de fechas
        $period = new DatePeriod(
          new DateTime($this->input->post('date')), // Donde empezamos a contar el periodo
          new DateInterval($p), // Definimos el periodo a 1 día, 1mes
          $this->input->post('num_fee'), // Aplicamos el numero de repeticiones
          DatePeriod::EXCLUDE_START_DATE
        );

        $num_quota = 1;

        foreach ($period as $date) {
          $weekDay = $date->format('N'); // Representación numérica del día de la semana
          $isSunday = false;
          if ($weekDay == '7') {
            $date->add(new DateInterval('P1D'));
            $fomattedDate = $date->format('Y-m-d');
            $isSunday = true;
          }

          if ($isSunday) {
            $date->add(new DateInterval('P1D'));
            $fomattedDate = $date->format('Y-m-d');
          } else {
            $fomattedDate = $date->format('Y-m-d');
          }

          $items[] = array(
            'date' => $fomattedDate,
            'num_quota' => $num_quota++,
            'fee_amount' => $this->input->post('fee_amount')
          );
        }
        $loan_data = $this->loans_m->array_from_post(['customer_id', 'credit_amount', 'interest_amount', 'num_fee', 'fee_amount', 'payment_m', 'coin_id', 'date']);
        $guarantors_list = $this->input->post('guarantors');
        $guarantors = [];
        if ($guarantors_list != null) // validar que el cliete seleccionado no exista en la lista de garantes
          for ($i = 0; $i < sizeof($guarantors_list); $i++) {
            if ($guarantors_list[$i] != $loan_data["customer_id"])
              $guarantors[$i] = $this->input->post('guarantors')[$i];
          }
        if ($loan_data['customer_id'] > 0) {
          if ($this->permission->getPermissionX([LOAN_CREATE, LOAN_ITEM_CREATE], FALSE))
            $customer = $this->customers_m->getCustomerByIdInAll($loan_data['customer_id']);
          elseif ($this->permission->getPermissionX([AUTHOR_LOAN_CREATE, AUTHOR_LOAN_ITEM_CREATE], FALSE))
            $customer = $this->customers_m->getCustomerById($this->user_id, $loan_data['customer_id']);
          if ($customer != null) {
            if ($this->guarantorsValidation($customer->user_id, $guarantors)) {
              if($this->formValidation($this->input)){
                if ($this->loans_m->addLoan($loan_data, $items, $guarantors)) {
                  $this->session->set_flashdata('msg', 'Préstamo agregado correctamente');
                } else {
                  $this->session->set_flashdata('msg_error', 'Ocurrió un error al guardar, intente nuevamente');
                }
              }else{
                $this->session->set_flashdata('msg_error', 'ERROR: ¡La información del formulario enviado no es consistente, intente nuevamente!');
              }
            } else {
              $this->session->set_flashdata('msg_error', '¡Uno o más garantes no existen en el equipo del asesor!');
            }
          } else {
            $this->session->set_flashdata('msg_error', '¡El cliente no existe!');
          }
        } else {
          $this->session->set_flashdata('msg_error', '¡No se seleccionó un cliente!');
        }
        redirect('admin/loans');
      } else {
        $data['subview'] = 'admin/loans/edit';
        $this->load->view('admin/_main_layout', $data);
      }
    } else {
      echo PERMISSION_DENIED_MESSAGE;
    }
  } // fin edit

  /**
   * Valida los datos de entrada, para constatar de que el cálculo es correcto
   * Criterios de validación (num_fee, fee_amount)
   */
  private function formValidation($input){
    $credit_amount = $input->post('credit_amount');
    $payment = $input->post('payment_m');
    $time = $input->post('time');
    $interest_amount = $input->post('interest_amount');
    $num_fee = 0;
    if (strtolower($payment) == 'mensual') {
      $num_fee = $time * 1;
    } else if (strtolower($payment) == 'quincenal') {
      $num_fee = $time * 2;
    } else if (strtolower($payment) == 'semanal') {
      $num_fee = $time * 4;
    } else if (strtolower($payment) == 'diario') {
      $num_fee = $time * 30;
    } else {
      $num_fee = 0;
    }
    $i = ($interest_amount / 100);
    $I = $credit_amount * $i * $time;
    $monto_total = $I + $credit_amount;
    $cuota = round($monto_total / $num_fee, 1);
    if($cuota == $input->post('fee_amount') && $num_fee == $input->post('num_fee')){
     return true;
    }
    else{
      return false;
    }
  }

  function view($id)
  {
    if ($this->permission->getPermissionX([LOAN_READ, LOAN_ITEM_READ], FALSE)) {
      $data['loan'] = $this->loans_m->getLoanInAll($id);
      $data['items'] = $this->loans_m->getLoanItemsInAll($id);
    } elseif($this->permission->getPermissionX([AUTHOR_LOAN_READ, AUTHOR_LOAN_ITEM_READ], FALSE)) {
      $data['loan'] = $this->loans_m->getLoan($this->session->userdata('user_id'), $id);
      $data['items'] = $this->loans_m->getLoanItems($this->session->userdata('user_id'), $id);
    }
    $this->load->view('admin/loans/view', $data);
    
  }

  // Valida que todos los garantes sean del mismo asesor que el cliente
  private function guarantorsValidation($user_id, $guarantors)
  {
    $valid = TRUE;
    if ($guarantors != null)
      foreach ($guarantors as $customer_id) {
        $guarantor = $this->customers_m->getCustomerByIdInAll($customer_id);
        if ($guarantor->user_id != $user_id) {
          $valid &= FALSE;
          break;
        }
      }
    return $valid;
  }


  /**
   * Muestra las cuotas proximas y la que ya están con mora
   * https://www.delftstack.com/es/howto/php/how-to-get-the-current-date-and-time-in-php/
   * https://www.php.net/manual/en/timezones.america.php
   */
  function quotes_week()
  {
    date_default_timezone_set('America/Caracas');
    $start_date = date("Y-m-d", time());
    $end_date = date("Y-m-d", strtotime($start_date.' + 7 days'));
    $data['items'] = $this->loans_m->quotesWeekAll($start_date, $end_date);
    $this->load->view('admin/loans/quotes_week', $data);
  }

}

/* End of file Loans.php */
/* Location: ./application/controllers/admin/Loans.php */