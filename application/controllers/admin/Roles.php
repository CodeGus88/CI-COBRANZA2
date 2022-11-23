<?php

defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . "/tools/UserPermission.php");

class Roles extends CI_Controller {

    private $user_id;
    private $permission;

    public function __construct(){
        parent::__construct();
        $this->load->model('role_m');
        $this->load->model('permission_m');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->session->userdata('loggedin') == TRUE || redirect('user/login');
        $this->user_id = $this->session->userdata('user_id');
        $this->permission = new Permission($this->permission_m, $this->user_id);
    }

    public function index(){
        $this->permission->getPermission([ROLE_READ], TRUE);
        $data[ROLE_CREATE] = $this->permission->getPermission([ROLE_CREATE], FALSE);
        $data[ROLE_READ] = $this->permission->getPermission([ROLE_READ], FALSE);
        $data[ROLE_UPDATE] = $this->permission->getPermission([ROLE_UPDATE], FALSE);
        $data[ROLE_DELETE] = $this->permission->getPermission([ROLE_DELETE], FALSE);
        $data['subview'] = 'admin/roles/index';
        $this->load->view('admin/_main_layout', $data);
    }

    /**
     * Mostrar los roles con paginación
     */
    public function ajax_roles(){
        $ROLE_READ = $this->permission->getPermission([ROLE_READ], FALSE);
        if (!$ROLE_READ) {
            $json_data = array(
                "draw"            => intval($this->input->post('draw')),
                "recordsTotal"    => intval(0),
                "recordsFiltered" => intval(0),
                "data"            => [],
            );
            echo json_encode($json_data);
            return;
        }
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value']?? '';
        $columns = ['id', 'full_name', 'roles', 'email', null];
        $columIndex = $this->input->post('order')['0']['column'] ?? 0;
        $order['column'] = $columns[$columIndex] ?? '';
        $order['dir'] = $this->input->post('order')['0']['dir'] ?? '';
        $query = $this->role_m->findAll($start, $length, $search, $order);
        if (sizeof($query['data']) == 0 && $start > 0) $query = $this->role_m->findAll(0, $length, $search, $order);
        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval(sizeof($query['data'])), // total registros para mostrar
            "recordsFiltered" => intval($query['recordsFiltered']), // total registro en base de datos
            "data"            => $query['data'], // Registros 
        );
        echo json_encode($json_data);
    }

    public function create(){

    }

    public function view($id){

    }

    public function edit($id){

    }

    public function delete($id){

    }

}