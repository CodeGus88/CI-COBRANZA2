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

  public function ajax_loas_cash_registers($user_id = 'all')
  {
    $start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search')['value']??'';
    $columns = ['name', 'user_name', 'total_mount', 'opening_date', 'closing_date', 'status', null];
    $columIndex = $this->input->post('order')['0']['column']??6;
    $order['column'] = $columns[$columIndex]??'';
    $order['dir'] = $this->input->post('order')['0']['dir']??'';
    $query = $this->cashregister_m->getCashRegistersAll($start, $length, $search, $order, $user_id);
    if(sizeof($query['data'])==0 && $start>0) $query = $this->cashregister_m->getCashRegistersAll(0, $length, $search, $order, $user_id);
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
        $datax['mount'] = $this->input->post('mount');
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
      $this->permission->getPermission([CASH_REGISTER_CREATE, AUTHOR_CASH_REGISTER_CREATE], TRUE);
      $data['coins'] = $this->db->get('coins')->result()??[];
      $data['name'] = 'Caja ' . ($this->cashregister_m->getLastId()->id + 1);
      $data['subview'] = 'admin/cash-registers/create';
      $this->load->view('admin/_main_layout', $data);
    }
  }

  public function view(){
    $cash_register_id = $this->input->get('cash_register_id');
    $data['subview'] = 'admin/cash-registers/view';
    $this->load->view('admin/_main_layout', $data);
  }

}

/* End of file Coins.php */
/* Location: ./application/controllers/admin/Coins.php */