<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include(APPPATH . "/tools/UserPermission.php");

class CashRegister extends CI_Controller {

  private $user_id;
  private $permission;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('cashregister_m');
    $this->load->model('permission_m');
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
    $this->user_id = $this->session->userdata('user_id');
    $this->permission = new Permission($this->permission_m, $this->user_id);
  }

  public function index()
  {
    if($this->permission->getPermission([CASH_REGISTER_READ], FALSE))
      $data['users'] = $this->db->order_by('id')->get('users')->result();
    $data['subview'] = 'admin/cash-registers/index';

    $this->load->view('admin/_main_layout', $data);
  }

  public function ajax_cash_registers($user_id = 'all')
  {
    $CASH_REGISTER_READ = $this->permission->getPermission([CASH_REGISTER_READ], FALSE);
    $AUTHOR_CASH_REGISTER_READ = $this->permission->getPermission([AUTHOR_CASH_REGISTER_READ], FALSE);
    if(!$CASH_REGISTER_READ) {
      if($AUTHOR_CASH_REGISTER_READ)
        $user_id = $this->user_id;
      else{
        $json_data = array(
          "draw"            => intval($this->input->post('draw')),
          "recordsTotal"    => intval(0), // total registros para mostrar
          "recordsFiltered" => intval(0), // total registro en base de datos
          "data"            => [], // Registros 
        );
        echo json_encode($json_data);
        return;
      }
        
    }
    $start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search')['value']??'';
    $columns = ['name', 'user_name', 'total_amount', 'opening_date', 'closing_date', 'status', null];
    $columIndex = $this->input->post('order')['0']['column']??6;
    $order['column'] = $columns[$columIndex]??'';
    $order['dir'] = $this->input->post('order')['0']['dir']??'';
    $query = $this->cashregister_m->getCashRegisters($start, $length, $search, $order, $user_id);
    if(sizeof($query['data'])==0 && $start>0) $query = $this->cashregister_m->getCashRegisters(0, $length, $search, $order, $user_id);
    $json_data = array(
      "draw"            => intval($this->input->post('draw')),
      "recordsTotal"    => intval(sizeof($query['data'])), // total registros para mostrar
      "recordsFiltered" => intval($query['recordsFiltered']), // total registro en base de datos
      "data"            => $query['data'], // Registros 
    );
    echo json_encode($json_data);
  }

  /**
   * Muestra el formulario
   */
  public function create(){
    $this->permission->getPermission([CASH_REGISTER_CREATE, AUTHOR_CASH_REGISTER_CREATE], TRUE);
    $this->form_validation->set_rules($this->cashregister_m->rules);
    if ($this->form_validation->run() == TRUE) {
      $data['name'] = $this->input->post('name');
      $data['user_id'] = $this->user_id;
      $data['coin_id'] = $this->input->post('coin_id');
      $data['status'] = TRUE;
      $object = new DateTime();
      $date = $object->format("Y-m-d h:i:s");
      $data['opening_date'] = $date;
      try{
        $this->db->trans_begin(); 
        $cash_register_id = $this->cashregister_m->cashRegisterInsert($data);
        $datax['cash_register_id'] = $cash_register_id;
        $datax['amount'] = $this->input->post('amount');
        $datax['description'] = $this->input->post('description');
        $datax['date'] = $date;
        $this->cashregister_m->manualInputInsert($datax);
        $this->db->trans_commit();
        $this->session->set_flashdata('msg', "Se abrió la caja " . $data['name']);
        redirect("admin/cashregister");
      }catch(Exception $e){
        $this->db->trans_rollback();
        $this->session->set_flashdata('msg_error', "¡Ocurrió un error durante el proceso! " . $e->getMessage());
        redirect("admin/cashregister");
      }
    }else{
      $data['coins'] = $this->db->get('coins')->result()??[];
      $data['name'] = 'Caja ' . ($this->cashregister_m->getLastId()->id + 1);
      $data['subview'] = 'admin/cash-registers/create';
      $this->load->view('admin/_main_layout', $data);
    }
  }

  public function view(){
    $cash_register_id = $this->input->get('id');
    $CASH_REGISTER_READ = $this->permission->getPermission([CASH_REGISTER_READ], FALSE);
    $AUTHOR_CASH_REGISTER_READ = $this->permission->getPermission([AUTHOR_CASH_REGISTER_READ], FALSE);
    if(!$CASH_REGISTER_READ) {
      if(!($AUTHOR_CASH_REGISTER_READ && $this->cashregister_m->isAuthor($cash_register_id, $this->user_id)))
        echo PERMISSION_DENIED_MESSAGE;
    }
    $data['cash_register'] = $this->cashregister_m->getCashRegister($cash_register_id);
    $data['subview'] = 'admin/cash-registers/view';
    $this->load->view('admin/_main_layout', $data);
  }

  public function ajax_manual_inputs($cash_register_id = 0){
    $CASH_REGISTER_READ = $this->permission->getPermission([CASH_REGISTER_READ], FALSE);
    $AUTHOR_CASH_REGISTER_READ = $this->permission->getPermission([AUTHOR_CASH_REGISTER_READ], FALSE);
    if(!$CASH_REGISTER_READ) {
      if(!($AUTHOR_CASH_REGISTER_READ && $this->cashregister_m->isAuthor($cash_register_id, $this->user_id)))
      { $json_data = array(
          "draw"            => intval($this->input->post('draw')),
          "recordsTotal"    => intval(0), // total registros para mostrar
          "recordsFiltered" => intval(0), // total registro en base de datos
          "data"            => [], // Registros 
        );
        echo json_encode($this->json_data);
        return;
      }
    }
    $start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search')['value']??'';
    $columns = ['id', 'amount', 'description', 'date'];
    $columIndex = $this->input->post('order')['0']['column'];
    $order['column'] = $columns[$columIndex]??'';
    $order['dir'] = $this->input->post('order')['0']['dir']??'';
    $query = $this->cashregister_m->getManualInputItems($start, $length, $search, $order, $cash_register_id);
    if(sizeof($query['data'])==0 && $start>0) $query = $this->cashregister_m->getManualInputItems(0, $length, $search, $order, $cash_register_id);
    $json_data = array(
      "draw"            => intval($this->input->post('draw')),
      "recordsTotal"    => intval(sizeof($query['data'])),
      "recordsFiltered" => intval($query['recordsFiltered']),
      "data"            => $query['data']
    );
    echo json_encode($json_data);
  }

  public function ajax_manual_outputs($cash_register_id = 0){
    $CASH_REGISTER_READ = $this->permission->getPermission([CASH_REGISTER_READ], FALSE);
    $AUTHOR_CASH_REGISTER_READ = $this->permission->getPermission([AUTHOR_CASH_REGISTER_READ], FALSE);
    if(!$CASH_REGISTER_READ) {
      if(!($AUTHOR_CASH_REGISTER_READ && $this->cashregister_m->isAuthor($cash_register_id, $this->user_id)))
      { $json_data = array(
          "draw"            => intval($this->input->post('draw')),
          "recordsTotal"    => intval(0),
          "recordsFiltered" => intval(0),
          "data"            => [],
        );
        echo json_encode($json_data);
        return;
      }
    }
    $start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search')['value']??'';
    $columns = ['id', 'amount', 'description', 'date'];
    $columIndex = $this->input->post('order')['0']['column'];
    $order['column'] = $columns[$columIndex]??'';
    $order['dir'] = $this->input->post('order')['0']['dir']??'';
    $query = $this->cashregister_m->getManualOutputItems($start, $length, $search, $order, $cash_register_id);
    if(sizeof($query['data'])==0 && $start>0) $query = $this->cashregister_m->getManualOutputItems(0, $length, $search, $order, $cash_register_id);
    $json_data = array(
      "draw"            => intval($this->input->post('draw')),
      "recordsTotal"    => intval(sizeof($query['data'])),
      "recordsFiltered" => intval($query['recordsFiltered']),
      "data"            => $query['data']
    );
    echo json_encode($json_data);
  }

  public function ajax_document_payment_inputs($cash_register_id = 0){
    $CASH_REGISTER_READ = $this->permission->getPermission([CASH_REGISTER_READ], FALSE);
    $AUTHOR_CASH_REGISTER_READ = $this->permission->getPermission([AUTHOR_CASH_REGISTER_READ], FALSE);
    if(!$CASH_REGISTER_READ) {
      if(!($AUTHOR_CASH_REGISTER_READ && $this->cashregister_m->isAuthor($cash_register_id, $this->user_id)))
      { $json_data = array(
          "draw"            => intval($this->input->post('draw')),
          "recordsTotal"    => intval(0),
          "recordsFiltered" => intval(0),
          "data"            => [],
        );
        echo json_encode($json_data);
        return;
      }
    }
    $start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search')['value']??'';
    $columns = ['id', 'customer_name', 'amount', 'pay_date'];
    $columIndex = $this->input->post('order')['0']['column']??1;
    $order['column'] = $columns[$columIndex]??'';
    $order['dir'] = $this->input->post('order')['0']['dir']??'';
    $query = $this->cashregister_m->getDocumentPaymentInputItems($start, $length, $search, $order, $cash_register_id);
    if(sizeof($query['data'])==0 && $start>0) $query = $this->cashregister_m->getDocumentPaymentInputItems(0, $length, $search, $order, $cash_register_id);
    $json_data = array(
      "draw"            => intval($this->input->post('draw')),
      "recordsTotal"    => intval(sizeof($query['data'])),
      "recordsFiltered" => intval($query['recordsFiltered']),
      "data"            => $query['data']
    );
    echo json_encode($json_data);
  }

  public function ajax_loan_outputs($cash_register_id = 0){
    $CASH_REGISTER_READ = $this->permission->getPermission([CASH_REGISTER_READ], FALSE);
    $AUTHOR_CASH_REGISTER_READ = $this->permission->getPermission([AUTHOR_CASH_REGISTER_READ], FALSE);
    if(!$CASH_REGISTER_READ) {
      if(!($AUTHOR_CASH_REGISTER_READ && $this->cashregister_m->isAuthor($cash_register_id, $this->user_id)))
      { $json_data = array(
          "draw"            => intval($this->input->post('draw')),
          "recordsTotal"    => intval(0),
          "recordsFiltered" => intval(0),
          "data"            => [],
        );
        echo json_encode($json_data);
        return;
      }
    }
    $start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search')['value']??'';
    $columns = ['id', 'customer_name', 'credit_amount', 'date'];
    $columIndex = $this->input->post('order')['0']['column']??1;
    $order['column'] = $columns[$columIndex]??'';
    $order['dir'] = $this->input->post('order')['0']['dir']??'';
    $query = $this->cashregister_m->getLoanOutputItems($start, $length, $search, $order, $cash_register_id);
    if(sizeof($query['data'])==0 && $start>0) $query = $this->cashregister_m->getLoanOutputItems(0, $length, $search, $order, $cash_register_id);
    $json_data = array(
      "draw"            => intval($this->input->post('draw')),
      "recordsTotal"    => intval(sizeof($query['data'])),
      "recordsFiltered" => intval($query['recordsFiltered']),
      "data"            => $query['data']
    );
    echo json_encode($json_data);
  }

}

/* End of file Coins.php */
/* Location: ./application/controllers/admin/Coins.php */