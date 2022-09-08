<?php
defined('BASEPATH') or exit('No direct script access allowed');

include(APPPATH . "/tools/UserPermission.php");

class Customers extends CI_Controller
{

  private $user_id;
  private $permission;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('customers_m');
    $this->load->model('permission_m');
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
    $this->user_id = $this->session->userdata('user_id');
    $this->permission = new Permission($this->permission_m, $this->user_id);
  }

  public function index()
  {
    // permisos del usuario [para la vista]
    $data[CUSTOMER_UPDATE] = $this->permission->getPermission([CUSTOMER_UPDATE], FALSE);
    $data[CUSTOMER_DELETE] = $this->permission->getPermission([CUSTOMER_DELETE], FALSE);
    $data[CUSTOMER_CREATE] = $this->permission->getPermission([CUSTOMER_CREATE], FALSE);
    $data[AUTHOR_CRUD] = $this->permission->getPermission([AUTHOR_CRUD], FALSE);
    // fin permisos del usuario [para la vista]
    $data['customers'] = Array();
    if($this->permission->getPermission([CUSTOMER_READ], FALSE)){
      $data['customers'] = $this->customers_m->getCustomers();
    }elseif($this->permission->getPermission([AUTHOR_CRUD], FALSE)){
      $data['customers'] = $this->customers_m->get_adviser_customers($this->user_id);
    }
    $data['subview'] = 'admin/customers/index';
    $this->load->view('admin/_main_layout', $data);
  }

  public function edit($id = NULL)
  {
    if ($id) {
      $row = $this->customers_m->get_customer_by_id($this->session->userdata('user_id'), $id);
      if ($row != null)
        $data['customer'] = $row;
      else
        $data['customer'] = $this->customers_m->get_new();
    }else {
      $data['customer'] = $this->customers_m->get_new();
    }

    $this->form_validation->set_rules($this->customers_m->customer_rules_x);

    if ($this->form_validation->run()) {

      $cst_data = $this->customers_m->array_from_post(['dni', 'first_name', 'last_name', 'gender', 'mobile', 'address', 'phone', 'business_name', 'ruc', 'company', 'user_id']);

      $isSuccessfull = false;
      $cst_data['first_name'] = strtoupper($cst_data['first_name']);
      $cst_data['last_name'] = strtoupper($cst_data['last_name']);
      if ($cst_data['user_id']) { // EDITAR REGISTRO
        if ($this->permission->getPermission([CUSTOMER_UPDATE], FALSE)) {
          $this->form_validation->set_rules($this->customers_m->customer_rules_x);
          if ($this->form_validation->run())
            $isSuccessfull = $this->customers_m->save($cst_data, $id);
        } elseif ($this->permission->getPermission([AUTHOR_CRUD], FALSE)) {
          $this->form_validation->set_rules($this->customers_m->customer_rules_x);
          if ($this->form_validation->run())
            if (AuthUserData::isAuthor($cst_data["user_id"])) {
              $isSuccessfull = $this->customers_m->save($cst_data, $id);
            }
        } else {
          $this->session->set_flashdata('msg_error', 'Permiso denegado...');
        }
      } else { // NUEVO REGISTRO
        if ($this->permission->getPermission([AUTHOR_CRUD, CUSTOMER_CREATE], FALSE)) {
          if ($this->form_validation->run() == TRUE) {
            $this->form_validation->set_rules($this->customers_m->customer_rules);
            if ($this->form_validation->run() == TRUE)
              $cst_data['user_id'] = $this->user_id;
            $isSuccessfull = $this->customers_m->save($cst_data, $id);
          }
        } else {
          $this->session->set_flashdata('msg_error', 'Permiso denegado...');
        }
      }

      if ($isSuccessfull) {
        if ($id) {
          $this->session->set_flashdata('msg', 'Cliente editado correctamente');
        } else {
          $this->session->set_flashdata('msg', 'Cliente agregado correctamente');
        }
      } else {
        $this->session->set_flashdata('msg_error', 'Hubo un problema al procesar los datos, intente nuevamente...');
      }

      redirect('admin/customers');
    }

    $data['subview'] = 'admin/customers/edit';
    $this->load->view('admin/_main_layout', $data);
  }

  public function delete($id)
  {
    if ($this->permission->getPermission([CUSTOMER_DELETE], FALSE)) {
      if ($this->customers_m->delete($id)==TRUE) $this->session->set_flashdata('msg', 'Se eliminó correctamente');
      else $this->session->set_flashdata('msg_error', '!Ops, algo salió mal¡');
    } elseif ($this->permission->getPermission([AUTHOR_CRUD], FALSE)) {
      if (AuthUserData::isAuthorX($this->customers_m, $id)) {
        if ($this->customers_m->delete($id)==TRUE) $this->session->set_flashdata('msg', 'Se eliminó correctamente');
        else $this->session->set_flashdata('msg_error', '!Ops, algo salió mal¡');
      } else {
        $this->session->set_flashdata('msg_error', 'Persmiso denegado...');
      }
    } else $this->session->set_flashdata('msg_error', 'Persmiso denegado...');
    redirect('admin/customers');
  }
}

/* End of file Customers.php */
/* Location: ./application/controllers/admin/Customers.php */