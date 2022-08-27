<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include(APPPATH."/tools/AuthUserData.php");

class Payments extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('payments_m');
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
  }

  public function index()
  {
    $data['payments'] = $this->payments_m->get_payments($this->session->userdata('user_id'));
    $data['subview'] = 'admin/payments/index';
    $this->load->view('admin/_main_layout', $data);
  }

  public function edit()
  {
    $data['customers'] = $this->payments_m->get_customers($this->session->userdata('user_id'));
    $data['subview'] = 'admin/payments/edit';
    $this->load->view('admin/_main_layout', $data);
  }

  function ajax_get_loan($customer_id) 
  {
    $quota_data = $this->payments_m->get_loan($this->session->userdata('user_id'), $customer_id);
    $search_data = ['loan'=>$quota_data];
    echo json_encode($search_data); // datos leidos por javascript Ajax
  }

  function ajax_get_loan_items($loan_id) 
  {
    $quota_data = $this->payments_m->get_loan_items($this->session->userdata('user_id'), $loan_id);
    $search_data = ['quotas'=>$quota_data];
    echo json_encode($search_data); // datos leidos por javascript Ajax
  }

  function ticket()
  {
    $data['customerName'] = $this->payments_m->get_customer_by_id($this->input->post('customer_id'));
    $data['coin'] = $this->input->post('coin');
    $data['loan_id'] = $this->input->post('loan_id');
    $probable_user_id = $this->payments_m->get_loan_adviser_user_id($this->input->post('loan_id'))->id;
    
    if(AuthUserData::permission($probable_user_id)){
      foreach ($this->input->post('quota_id') as $q) {
        $this->payments_m->update_quota(['status' => 0], $q);
      }

      if (!$this->payments_m->check_cstLoan($this->input->post('loan_id'))) {
        $this->payments_m->update_cstLoan($this->input->post('loan_id'), $this->input->post('customer_id'));
      }

      $data['quotasPaid'] = $this->payments_m->get_quotasPaid($this->input->post('quota_id'));
      $data['userFulName'] = $this->session->userdata('first_name') . " " . $this->session->userdata('last_name');

      $this->load->view('admin/payments/ticket', $data);
    }else{
      echo 'ERROR: permission denied'; 
    }
    
  }

}

/* End of file Payments.php */
/* Location: ./application/controllers/admin/Payments.php */