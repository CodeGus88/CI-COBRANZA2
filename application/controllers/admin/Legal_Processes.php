<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . "/tools/UserPermission.php");


class Legal_Processes extends CI_Controller
{

  private $user_id;
  private $permission;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('legal_process_m');
    $this->load->model('permission_m');
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
    $this->user_id = $this->session->userdata('user_id');
    $this->permission = new Permission($this->permission_m, $this->user_id);
  }

  public function index()
  {
    if (!$this->permission->getPermission([COIN_READ], FALSE)) show_error("You don't have access to this site", 403, 'DENIED ACCESS');
    $data['subview'] = 'admin/legal-processes/index';
    $this->load->view('admin/_main_layout', $data);
  }

  public function ajax_legal_processes()
  {
    $LEGAL_PROCESSES_READ = TRUE; //$this->permission->getPermission([LEGAL_PROCESSES_READ], FALSE);
    if (!$LEGAL_PROCESSES_READ) { 
        $json_data = array(
          "draw"            => intval($this->input->post('draw')),
          "recordsTotal"    => intval(0),
          "recordsFiltered" => intval(0),
          "data"            => [],
        );
        echo json_encode($this->json_data);
        return;
      }
      $start = $this->input->post('start');
      $length = $this->input->post('length');
      $search = $this->input->post('search')['value'] ?? '';
      $columns = ['id', 'customer', 'start_date', ''];
      $columIndex = $this->input->post('order')['0']['column'] ?? 3;
      $order['column'] = $columns[$columIndex] ?? '';
      $order['dir'] = $this->input->post('order')['0']['dir'] ?? '';
      $query = $this->legal_process_m->findAll($start, $length, $search, $order);
      if (sizeof($query['data']) == 0 && $start > 0) $query = $this->legal_process_m->findAll(0, $length, $search, $order);
      $json_data = array(
        "draw"            => intval($this->input->post('draw')),
        "recordsTotal"    => intval(sizeof($query['data'])),
        "recordsFiltered" => intval($query['recordsFiltered']),
        "data"            => $query['data']
      );
      echo json_encode($json_data);
    }

  public function create()
  {
    $this->form_validation->set_rules($this->legal_process_m->rules);
    if ($this->form_validation->run()) {
      $data = [
        'customer_id' => $this->input->post('customer_id'),
        'observations' => $this->input->post('observations'),
        'start_date' => $this->input->post('start_date'),
        
      ];

      $legal_process_id = $this->legal_process_m->add($data);

      if ($legal_process_id){
        // Guardar imagenes
        $files = [];
        for($i = 1; $i <= 5; $i++){
          $obj = $this->saveFile("img$i");
          if($obj)
            array_push($files, ['legal_process_id' => $legal_process_id, 'name' => $obj['file_name']]);
        }
        // Registrar archivos en la base de datos
        $this->legal_process_m->addFiles($files);
        $this->session->set_flashdata('msg', 'Se creó el proceso correctamente');
        redirect('/admin/legal_processes');
      } else $this->session->set_flashdata('msg_error', 'Algo salió mal...');
    } else {
      $form = new stdClass();
      $form->customer_id = $this->input->post('customer_id') ?? '';
      $form->observations = $this->input->post('observations') ?? '';
      $form->start_date = $this->input->post('start_date') ?? null;
      $data['form_state'] = $form;
    };
    $data['customers'] = $this->legal_process_m->findLateDebtorCustomers();
    $data['subview'] = 'admin/legal-processes/edit';
    return $this->load->view('admin/_main_layout', $data);
  }


  private function saveFile($inputName)
  {
      $fileName = str_replace(' ','',str_replace('-', '', str_replace(':', '', Date('Y-m-d H:i:s')))) . uniqid();
      $config['upload_path'] = '././uploads';
      $config['file_name'] = $fileName;
      $config['allowed_types'] = 'jpg|png';
      $config['max_size'] = '5000';
      $config['max_width'] = '2000';
      $config['max_height'] = '2000';

      $this->load->library('upload', $config);

      if(!$this->upload->do_upload($inputName)){
        echo $this->upload->display_errors();
        return;
      }
      return $this->upload->data();
  }

  public function edit()
  {

  }

  public function view($id)
  {
    $data['legal_process'] = $this->legal_process_m->findById($id);
    $data['subview'] = 'admin/legal-processes/view';
    return $this->load->view('admin/_main_layout', $data);
  }

  public function delete()
  {

  }
}

/* End of file Coins.php */
/* Location: ./application/controllers/admin/Coins.php */