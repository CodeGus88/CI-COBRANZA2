<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments_m extends CI_Model {

  public function get_payments($user_id)
  {
    $this->db->select("li.id, c.dni, concat(c.first_name,' ',c.last_name) AS name_cst, l.id AS loan_id, li.pay_date, li.num_quota, li.fee_amount");
    $this->db->from('loan_items li');
    $this->db->join('loans l', 'l.id = li.loan_id', 'left');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->join('users u', 'u.id = c.user_id', 'left');
    $this->db->where('li.status', 0);
    $this->db->where('u.id', $user_id);
    $this->db->order_by('li.pay_date', 'desc');
    return $this->db->get()->result(); 
  }

  public function get_searchCst($user_id, $dni)
  {
    $this->db->select("l.id as loan_id, l.customer_id, c.dni, concat(c.first_name, ' ', c.last_name) AS cst_name, l.credit_amount, l.payment_m, co.name as coin_name");
    $this->db->from('customers c');
    $this->db->join('loans l', 'l.customer_id = c.id', 'left');
    $this->db->join('coins co', 'co.id = l.coin_id', 'left');
    $this->db->join('users u', 'u.id = c.user_id', 'left');
    $this->db->where(['c.loan_status' => 1, 'l.status' => 1, 'c.dni' => $dni]);
    $this->db->where("u.id", $user_id);
    return $this->db->get()->row(); 
  }

  public function get_quotasCst($user_id, $loan_id)
  {
    $this->db->select("li.id, li.loan_id, li.date, li.num_quota, li.fee_amount, li.pay_date, li.status");
    $this->db->from('loan_items li');
    $this->db->join('loans l', 'l.id = li.loan_id');
    $this->db->join('customers c', 'c.id = l.customer_id');
    $this->db->join('users u', 'u.id = c.user_id');
    $this->db->where(['loan_id'=>$loan_id, 'u.id'=> $user_id]);
    return $this->db->get()->result();
  }

  public function update_quota($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('loan_items', $data); 
  }

  public function check_cstLoan($loan_id)
  {
    $this->db->where('loan_id', $loan_id);

    $query = $this->db->get('loan_items'); 

    $check = false;

    foreach ($query->result() as $row) {
      if ($row->status == 1) {
        $check = true;
        break;
      } 
    }

    return $check;
  }

  public function update_cstLoan($loan_id, $customer_id)
  {
    $this->db->where('id', $loan_id);
    $this->db->update('loans', ['status' => 0]);

    $this->db->where('id', $customer_id);
    $this->db->update('customers', ['loan_status' => 0]); 
  }

  public function get_quotasPaid($data)
  {
    $this->db->where_in('id', $data);
    return $this->db->get('loan_items')->result();
  }

  // Funciones para validación
  // Retorna el id del usuario consejero del prestamo
  public function get_loan_adviser_user_id($loan_id){
    $this->db->select('u.id');
    $this->db->from('users u');
    $this->db->join('customers c', 'c.user_id = u.id');
    $this->db->join('loans l', 'l.customer_id = c.id');
    $this->db->where('l.id', $loan_id);
    return $this->db->get()->row();
  }

}

/* End of file Payments_m.php */
/* Location: ./application/models/Payments_m.php */