<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . "/tools/UserPermission.php");

class Payments extends CI_Controller
{

  private $user_id;
  private $permission;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('payments_m');
    $this->load->model('permission_m');
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
    $this->user_id = $this->session->userdata('user_id');
    $this->permission = new Permission($this->permission_m, $this->user_id);
  }

  public function index($user_id = 0)
  {
    $data[LOAN_UPDATE] =  $this->permission->getPermission([LOAN_UPDATE], FALSE);
    $data[LOAN_ITEM_UPDATE] = $this->permission->getPermission([LOAN_ITEM_UPDATE], FALSE);
    $data[AUTHOR_LOAN_UPDATE] =  $this->permission->getPermission([AUTHOR_LOAN_UPDATE], FALSE);
    $data[AUTHOR_LOAN_ITEM_UPDATE] = $this->permission->getPermission([AUTHOR_LOAN_ITEM_UPDATE], FALSE);
    $data['payments'] = array();
    if ($this->permission->getPermissionX([LOAN_READ, LOAN_ITEM_READ], FALSE)) {
      $data['users'] = $this->db->get('users')->result();
      $data['selected_user_id'] = $user_id;
      if($user_id == 0){
        $data['payments'] = $this->payments_m->getPaymentsAll();
      }else{
        $data['payments'] = $this->payments_m->getPayments($user_id);
      }
    } elseif ($this->permission->getPermissionx([AUTHOR_LOAN_READ, AUTHOR_LOAN_ITEM_READ], FALSE)) {
      $data['payments'] = $this->payments_m->getPayments($this->user_id);
    }
    $data['subview'] = 'admin/payments/index';
    $this->load->view('admin/_main_layout', $data);
  }

  public function edit()
  {
    $this->permission->getPermissionY(
      $this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE) || $this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE),
      TRUE
    );
    $data['customers'] = array();
    if ($this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE))
      $data['customers'] = $this->payments_m->getCustomersAll();
    elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE))
      $data['customers'] = $this->payments_m->get_customers($this->user_id);
    $data['subview'] = 'admin/payments/edit';
    $this->load->view('admin/_main_layout', $data);
  }

  function ajax_get_loan($customer_id)
  {
    if ($this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE))
      $quota_data = $this->payments_m->getLoanAll($customer_id);
    elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE))
      $quota_data = $this->payments_m->get_loan($this->user_id, $customer_id);
    $search_data = ['loan' => $quota_data];
    echo json_encode($search_data); // datos leidos por javascript Ajax
  }

  function ajax_get_loan_items($loan_id)
  {
    $quota_data = array();
    if ($this->permission->getPermission([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE))
      $quota_data = $this->payments_m->getLoanItemsAll($loan_id);
    elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE))
      $quota_data = $this->payments_m->get_loan_items($this->user_id, $loan_id);
    $search_data = ['quotas' => $quota_data];
    echo json_encode($search_data); // datos leidos por javascript Ajax
  }

  function ajax_get_guarantors($loan_id)
  {
    $guarantors = array();
    if ($this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE))
      $guarantors = $this->payments_m->getGuarantorsAll($loan_id);
    elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE))
      $guarantors = $this->payments_m->get_guarantors($this->user_id, $loan_id);
    $search_datax = ['guarantors' => $guarantors];
    echo json_encode($search_datax); // datos leidos por javascript Ajax
  }

  function ticket()
  {
    if ($this->input->post('customer_id') != null) { // valida que no se acceda desde la url sin datos de entrada
      if ($this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE))
        $data['customerName'] = $this->payments_m->getCustomerByIdAll($this->input->post('customer_id'));
      elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE))
        $data['customerName'] = $this->payments_m->get_customer_by_id($this->user_id, $this->input->post('customer_id'));
      $data['coin'] = $this->input->post('coin');
      $data['loan_id'] = $this->input->post('loan_id');

      if ($this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE)) {
        $this->updateState($this->input->post('loan_id'), $this->input->post('quota_id'), $this->input->post('customer_id'), $data);
      } elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE)) {
        $probable_user_id = $this->payments_m->get_loan_adviser_user_id($this->input->post('loan_id'))->id;
        if (AuthUserData::isAuthor($probable_user_id)) {
          $this->updateState($this->input->post('loan_id'), $this->input->post('quota_id'), $this->input->post('customer_id'), $data);
        } else {
          echo PERMISSION_DENIED_MESSAGE;
        }
      } else {
        echo PERMISSION_DENIED_MESSAGE;
      }
    } else {
      echo loadErrorMessage('¡Imposible acceder a está página, faltan datos de entrada de la transacción!');
    }
  }

  /**
   * $this->input->post('loan_id') - $loan_id
   * $this->input->post('quota_id') - $quota_id
   * $this->input->post('customer_id') - $customer_id
   */
  private function updateState($loan_id, $quota_id, $customer_id, $data)
  {
    foreach ($quota_id as $q) {
      $this->payments_m->update_quota(['status' => 0, 'payment_user_id' => $this->user_id], $q);
    }
    if (!$this->payments_m->check_cstLoan($loan_id)) {
      $this->payments_m->update_cstLoan($loan_id, $customer_id);
    }
    $data['quotasPaid'] = $this->payments_m->get_quotasPaid($quota_id);
    $data['customerAdvisorName'] = $this->payments_m->getCustomerAdvisorName($customer_id)->user_name;
    $data['payment_user_name'] = $this->session->userdata('academic_degree') .
      " " . $this->session->userdata('first_name') .
      " " . $this->session->userdata('last_name');
    $this->load->view('admin/payments/ticket', $data);
  }
}

/* End of file Payments.php */
/* Location: ./application/controllers/admin/Payments.php */