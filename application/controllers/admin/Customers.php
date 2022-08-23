<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include(APPPATH."/tools/AuthUserData.php");

class Customers extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('customers_m');
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
  }

  public function index()
  {
    $data['customers'] = $this->customers_m->get_adviser_customers($this->session->userdata('user_id'));
    $data['subview'] = 'admin/customers/index';
    $this->load->view('admin/_main_layout', $data);
  }

  public function edit($id = NULL)
  {
    if ($id) {
      $row = $this->customers_m->get_customer_by_id($this->session->userdata('user_id'), $id);
      if($row != null)
        $data['customer'] = $row;
      else
        $data['customer'] = $this->customers_m->get_new();
    } else {
      $data['customer'] = $this->customers_m->get_new();
    }

    $rules = $this->customers_m->customer_rules;
   
    $this->form_validation->set_rules($rules);

    if ($this->form_validation->run() == TRUE) {
      
      $cst_data = $this->customers_m->array_from_post(['dni','first_name', 'last_name', 'gender', 'mobile', 'address', 'phone', 'business_name', 'ruc', 'company', 'user_id']);
      
      $isSuccessfull = false;
      $cst_data['first_name'] = strtoupper($cst_data['first_name']);
      $cst_data['last_name'] = strtoupper($cst_data['last_name']);
      if($cst_data['user_id']){
        if(AuthUserData::permission($cst_data["user_id"])){
          $isSuccessfull = $this->customers_m->save($cst_data, $id);
        }
      }else{
        $cst_data['user_id'] = $this->session->userdata('user_id');
        $isSuccessfull = $this->customers_m->save($cst_data, $id);
      }

      if($isSuccessfull){
        if ($id) {
          $this->session->set_flashdata('msg', 'Cliente editado correctamente');
        } else {
          $this->session->set_flashdata('msg', 'Cliente agregado correctamente');
        }
      }else{
        $this->session->set_flashdata('msg_error', 'Hubo un problema al procesar los datos, intente nuevamente...');
      }
      
      redirect('admin/customers');

    }

    $data['subview'] = 'admin/customers/edit';
    $this->load->view('admin/_main_layout', $data);
  }

}

/* End of file Customers.php */
/* Location: ./application/controllers/admin/Customers.php */