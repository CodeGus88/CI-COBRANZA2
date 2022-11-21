<?php

use LDAP\Result;
include(APPPATH."/models/IAuthor.php");

defined('BASEPATH') OR exit('No direct script access allowed');

class Customers_m extends MY_Model implements IAuthor {

  protected $_table_name = 'customers';
  protected $id = 'id';

  public $customer_rules = array(
    array(
      'field' => 'dni',
      'label' => 'CI',
      'rules' => 'trim|required|is_unique[customers.dni]',
    ),
    array(
      'field' => 'first_name',
      'label' => 'nombre(s)',
      'rules' => 'trim|required'
    ),
    array(
      'field' => 'last_name',
      'label' => 'apellido(s)',
      'rules' => 'trim|required'
    )
  );

  public $customer_rules_x = array(
    array(
      'field' => 'dni',
      'label' => 'CI',
      'rules' => 'trim|required',
    ),
    array(
      'field' => 'first_name',
      'label' => 'nombre(s)',
      'rules' => 'trim|required'
    ),
    array(
      'field' => 'last_name',
      'label' => 'apellido(s)',
      'rules' => 'trim|required'
    )
  );

  public function get_new()
  {
    $customer = new stdClass(); //clase vacia
    $customer->dni = '';
    $customer->first_name = '';
    $customer->last_name = '';
    $customer->gender = 'none';
    $customer->address = '';
    $customer->mobile = '';
    $customer->phone = '';
    $customer->business_name = '';
    $customer->ruc = '';
    $customer->company = '';
    $customer->user_id = '';
    return $customer;
  }
  // public function getCustomersAll(){
  //   return $this->db->from('customers')->get()->result();
  // }

  // public function getCustomers($user_id){
  //   $this->db->select('*');
  //   $this->db->from('customers c');
  //   $this->db->where('c.user_id', $user_id);
  //   return $this->db->get()->result();
  // }

  public function getCustomers($user_id = null){
    $this->db->select('*');
    $this->db->from('customers c');
    if($user_id != 'all' && $user_id != null)
      $this->db->where('c.user_id', $user_id);
    return $this->db->get()->result();
  }

  public function getCustomerByIdInAll($customer_id){
    $this->db->select('*');
    $this->db->from('customers');
    $this->db->where("id" ,$customer_id);
    $query = $this->db->get();
    if ($query->num_rows() > 0)
      return $query->row();
    else
      return null;
  }

  public function getCustomerById($user_id, $customer_id){
    $this->db->select('*');
    $this->db->from('customers');
    $this->db->where("(user_id = $user_id AND id = $customer_id)");
    $query = $this->db->get();
    if ($query->num_rows() > 0)
      return $query->row();
    else
      return null;
  }

  public function delete($customer_id){
    return $this->db->delete('customers', array('id'=>$customer_id));
  }

  public function getAuthorId($model_id){
    $this->db->select('c.user_id');
    $this->db->from('customers c');
    $this->db->where('id', $model_id);
    return $this->db->get()->row();
  }

}

/* End of file Customers_m.php */
/* Location: ./application/models/Customers_m.php */