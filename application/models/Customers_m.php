<?php

use LDAP\Result;

defined('BASEPATH') OR exit('No direct script access allowed');

class Customers_m extends MY_Model {

  protected $_table_name = 'customers';
  // private $id = 'id';

  public $customer_rules = array(
    array(
      'field' => 'dni',
      'label' => 'dni',
      'rules' => 'trim|required'
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

  public function get_adviser_customers($adviser_id){
    return $this->db->get_where("customers", array("user_id" => $adviser_id))->result();
  }

  public function get_customer_by_id($user_id, $customer_id){
    $this->db->select('*');
    $this->db->from('customers');
    $this->db->where("(user_id = $user_id AND id = $customer_id)");
    $query = $this->db->get();
    if ($query->num_rows() > 0)
      return $query->row();
    else
      return null;
  }
}

/* End of file Customers_m.php */
/* Location: ./application/models/Customers_m.php */