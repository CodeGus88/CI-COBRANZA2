<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loans extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('loans_m');
    $this->load->model('customers_m');
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
  }

  public function index()
  {
    $data['loans'] = $this->loans_m->get_loans($this->session->userdata('user_id'));
    $data['subview'] = 'admin/loans/index';
    $this->load->view('admin/_main_layout', $data);
  }

  public function edit()
  {
    $data['coins'] = $this->loans_m->get_coins();

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
      echo "Numero de periodos: " . $this->input->post('num_fee');
      $period = new DatePeriod( 
                    new DateTime($this->input->post('date')), // Donde empezamos a contar el periodo
                    new DateInterval($p), // Definimos el periodo a 1 día, 1mes
                    $this->input->post('num_fee'), // Aplicamos el numero de repeticiones
                    DatePeriod::EXCLUDE_START_DATE);

      $num_quota = 1; 

      foreach ($period as $date) {

        $weekDay = $date->format('N'); // Representación numérica del día de la semana
        $isSunday = false;
        if ($weekDay == '7') {
          $date->add(new DateInterval('P1D'));
          $fomattedDate = $date->format('Y-m-d');
          $isSunday = true;
        } //else {

            if ($isSunday) {
              $date->add(new DateInterval('P1D'));
              $fomattedDate = $date->format('Y-m-d');
            } else {
              $fomattedDate = $date->format('Y-m-d');
            }
       // }


        $items[] = array(
          'date' => $fomattedDate,
          'num_quota' => $num_quota++,
          'fee_amount' => $this->input->post('fee_amount')
        );
      }

      $loan_data = $this->loans_m->array_from_post(['customer_id','credit_amount', 'interest_amount', 'num_fee', 'fee_amount', 'payment_m', 'coin_id', 'date']);
      
      $customer = $this->customers_m->get_customer_by_id(
        $this->session->userdata('user_id'),
        $loan_data['customer_id']
      );
      if($customer != null){
        if ($this->loans_m->add_loan($loan_data, $items)) {
          $this->session->set_flashdata('msg', 'Prestamo agregado correctamente');
        }else{
          $this->session->set_flashdata('msg_error', 'Ocurrió un error al guardar, intente nuevamente');
        }
      }else{
        $this->session->set_flashdata('msg_error', '¡El cliente no existe!');
      }
      redirect('admin/loans');
    }
    $data['subview'] = 'admin/loans/edit';
    $this->load->view('admin/_main_layout', $data);
  } // fin edit

  function ajax_searchCst() 
  {
    $dni = $this->input->post('dni');
    $cst = $this->loans_m->get_searchCst($this->session->userdata('user_id'), $dni);
    echo json_encode($cst);
  }

  function view($id)
  {
    $data['loan'] = $this->loans_m->get_loan($this->session->userdata('user_id'), $id);
    $data['items'] = $this->loans_m->get_loanItems($this->session->userdata('user_id'), $id);
    $this->load->view('admin/loans/view', $data);
  }

}

/* End of file Loans.php */
/* Location: ./application/controllers/admin/Loans.php */