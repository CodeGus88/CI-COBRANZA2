<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loans_m extends MY_Model {

  protected $_table_name = 'loans';

  public $loan_rules = array(
    array(
      'field' => 'customer_id',
      'rules' => 'trim|required',
      'errors' => array(
                    'required' => 'buscar persona para realizar prestamo',
                ),
    )
  );

  public function get_loans($user_id)
  {
    $this->db->select("l.id, CONCAT(c.first_name, ' ', c.last_name) AS customer, l.credit_amount, l.interest_amount, co.short_name, l.status");
    $this->db->from('loans l');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->join('coins co', 'co.id = l.coin_id', 'left');
    $this->db->join('users u', 'u.id = c.user_id');
    $this->db->order_by('l.id', 'desc');
    $this->db->where("u.id = $user_id");
    return $this->db->get()->result();
  }

  public function get_coins()
  {
    return $this->db->get('coins')->result(); 
  }

  public function get_searchCst($user_id,$dni)
  {
    $this->db->where('dni', $dni);
    $this->db->where('user_id', $user_id);
    return $this->db->get('customers')->row();
  }

  public function add_loan($data, $items) {

    if ($this->db->insert('loans', $data)) {
      $loan_id = $this->db->insert_id();

      $this->db->where('id', $data['customer_id']);
      $this->db->update('customers', ['loan_status' => 1]);

      foreach ($items as $item) {
        $item['loan_id'] = $loan_id;
        $this->db->insert('loan_items', $item);
      }

      return true;
    }

    return false;
  }

  public function get_loan($user_id, $loan_id)
  {
    $this->db->select("l.*, CONCAT(c.first_name, ' ', c.last_name) AS customer_name, co.short_name");
    $this->db->from('loans l');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->join('coins co', 'co.id = l.coin_id', 'left');
    $this->db->join('users u', 'u.id = c.user_id', 'left');
    $this->db->where('l.id', $loan_id);
    $this->db->where('u.id', $user_id);

    return $this->db->get()->row(); 
  }

  public function get_loanItems($user_id, $loan_id)
  {
    $this->db->select('li.id, li.loan_id, li.date, li.num_quota, li.fee_amount, li.pay_date, li.status');
    $this->db->from('loan_items li');
    $this->db->join('loans l', 'l.id = li.loan_id');
    $this->db->join('customers c', 'c.id = l.customer_id');
    $this->db->join('users u', 'u.id = c.user_id');
    $this->db->where('l.id', $loan_id);
    $this->db->where('u.id', $user_id);
    return $this->db->get()->result();
  }

}

/* End of file Loans_m.php */
/* Location: ./application/models/Loans_m.php */