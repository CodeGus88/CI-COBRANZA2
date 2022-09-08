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
    $data[AUTHOR_CRUD] = $this->permission->getPermission([AUTHOR_CRUD], FALSE);
    $data[LOAN_ITEM_READ] = $this->permission->getPermission([LOAN_ITEM_READ], FALSE);
    $data['loans'] = array();
    if ($this->permission->getPermission([LOAN_READ], FALSE)) {
      $data['loans'] = $this->loans_m->getLoansAll();
    } elseif ($this->permission->getPermission([AUTHOR_CRUD], FALSE)) {
      $data['loans'] = $this->loans_m->getLoans($this->user_id);
    }
    $data['subview'] = 'admin/loans/index';
    $this->load->view('admin/_main_layout', $data);
  }

  public function edit()
  {
    if (
      $this->permission->getPermission([AUTHOR_CRUD], FALSE) ||
      $this->permission->getPermissionX([LOAN_CREATE], FALSE)
    ) {
      $data['coins'] = $this->loans_m->getCoins();
      if ($this->permission->getPermissionX([LOAN_CREATE], FALSE)) {
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
        if ($guarantors_list != null) // validar que el cliete seleccionado no exista en la lista de garantes
          for ($i = 0; $i < sizeof($guarantors_list); $i++) {
            if ($guarantors_list[$i] != $loan_data["customer_id"])
              $guarantors[$i] = $this->input->post('guarantors')[$i];
          }
        if ($loan_data['customer_id'] > 0) {
          if ($this->permission->getPermissionX([LOAN_CREATE], FALSE))
            $customer = $this->customers_m->get_customer_by_id_in_all($loan_data['customer_id']);
          elseif ($this->permission->getPermissionX([AUTHOR_CRUD], FALSE))
            $customer = $this->customers_m->get_customer_by_id($this->user_id, $loan_data['customer_id']);
          if ($customer != null) {
            if ($this->guarantorsValidation($customer->user_id, $guarantors)) {
              if ($this->loans_m->addLoan($loan_data, $items, $guarantors)) {
                $this->session->set_flashdata('msg', 'Prestamo agregado correctamente');
              } else {
                $this->session->set_flashdata('msg_error', 'Ocurrió un error al guardar, intente nuevamente');
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

  function view($id)
  {
    if ($this->permission->getPermissionX([LOAN_READ, LOAN_ITEM_READ], FALSE)) {
      $data['loan'] = $this->loans_m->getLoanInAll($id);
      $data['items'] = $this->loans_m->getLoanItemsInAll($id);
    } elseif($this->permission->getPermission([AUTHOR_CRUD], FALSE)) {
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
}

/* End of file Loans.php */
/* Location: ./application/controllers/admin/Loans.php */