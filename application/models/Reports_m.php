<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_m extends CI_Model {

  public function get_reportLoanAll($coin_id)
  {
    $this->db->select('c.short_name, sum(l.credit_amount) as sum_credit');
    $this->db->join('coins c', 'c.id = l.coin_id', 'left');
    $this->db->where('l.coin_id', $coin_id);
    $cr = $this->db->get('loans l')->row();

    $this->db->select('c.short_name, sum(TRUNCATE(l.credit_amount*(l.interest_amount/100) + l.credit_amount,2)) AS cr_interest');
    $this->db->join('coins c', 'c.id = l.coin_id', 'left');
    $this->db->where('l.coin_id', $coin_id);
    $cr_interest = $this->db->get('loans l')->row();

    $this->db->select('c.short_name, sum(TRUNCATE(l.credit_amount*(l.interest_amount/100) + l.credit_amount,2)) AS cr_interestPaid');
    $this->db->join('coins c', 'c.id = l.coin_id', 'left');
    $this->db->where(['l.coin_id' => $coin_id, 'l.status' => 0]);
    $cr_interestPaid = $this->db->get('loans l')->row();

    $this->db->select('c.short_name, sum(TRUNCATE(l.credit_amount*(l.interest_amount/100) + l.credit_amount,2)) AS cr_interestPay');
    $this->db->join('coins c', 'c.id = l.coin_id', 'left');
    $this->db->where(['l.coin_id' => $coin_id, 'l.status' => 1]);
    $cr_interestPay = $this->db->get('loans l')->row();

    $credits = [$cr, $cr_interest, $cr_interestPaid, $cr_interestPay];

    return $credits;
  }

  public function get_reportLoan($user_id, $coin_id)
  {
    $this->db->select('c.short_name, sum(l.credit_amount) as sum_credit');
    $this->db->join('coins c', 'c.id = l.coin_id');
    $this->db->join('customers cu', 'cu.id = l.customer_id');
    $this->db->join('users u', 'u.id = cu.user_id');
    $this->db->where('l.coin_id', $coin_id);
    $this->db->where('u.id', $user_id);
    $cr = $this->db->get('loans l')->row();

    $this->db->select('c.short_name, sum(TRUNCATE(l.credit_amount*(l.interest_amount/100) + l.credit_amount,2)) AS cr_interest');
    $this->db->join('coins c', 'c.id = l.coin_id');
    $this->db->join('customers cu', 'cu.id = l.customer_id');
    $this->db->join('users u', 'u.id = cu.user_id');
    $this->db->where('l.coin_id', $coin_id);
    $this->db->where('u.id', $user_id);
    $cr_interest = $this->db->get('loans l')->row();

    $this->db->select('c.short_name, sum(TRUNCATE(l.credit_amount*(l.interest_amount/100) + l.credit_amount,2)) AS cr_interestPaid');
    $this->db->join('coins c', 'c.id = l.coin_id');
    $this->db->join('customers cu', 'cu.id = l.customer_id');
    $this->db->join('users u', 'u.id = cu.user_id');
    $this->db->where(['l.coin_id' => $coin_id, 'l.status' => 0]);
    $this->db->where('u.id', $user_id);
    $cr_interestPaid = $this->db->get('loans l')->row();

    $this->db->select('c.short_name, sum(TRUNCATE(l.credit_amount*(l.interest_amount/100) + l.credit_amount,2)) AS cr_interestPay');
    $this->db->join('coins c', 'c.id = l.coin_id');
    $this->db->join('customers cu', 'cu.id = l.customer_id');
    $this->db->join('users u', 'u.id = cu.user_id');
    $this->db->where(['l.coin_id' => $coin_id, 'l.status' => 1]);
    $this->db->where('u.id', $user_id);
    $cr_interestPay = $this->db->get('loans l')->row();

    $credits = [$cr, $cr_interest, $cr_interestPaid, $cr_interestPay];

    return $credits;
  }

  public function get_reportCoin($coin_id)
  {
    $this->db->where('id', $coin_id);

    return $this->db->get('coins')->row(); 
  }

  public function get_reportDatesAll($coin_id, $start_date, $end_date)
  {
    $this->db->select("l.id, l.date, l.credit_amount, l.interest_amount, l.num_fee, l.payment_m,
     (l.num_fee*l.fee_amount) AS total_int, l.status");
    $this->db->from('loans l');
    $this->db->where('coin_id', $coin_id);
    $this->db->where("date BETWEEN '{$start_date}' AND '{$end_date}'");

    return $this->db->get()->result(); 
  }

  public function get_reportDates($user_id, $coin_id, $start_date, $end_date)
  {
    $this->db->select("l.id, l.date, l.credit_amount, l.interest_amount, l.num_fee, l.payment_m,
     (l.num_fee*l.fee_amount) AS total_int, l.status");
    $this->db->from('loans l');
    $this->db->join('customers c', 'c.id = l.customer_id');
    $this->db->join('users u', 'u.id = c.user_id');
    $this->db->where('coin_id', $coin_id);
    $this->db->where('u.id', $user_id);
    $this->db->where("date BETWEEN '{$start_date}' AND '{$end_date}'");
    return $this->db->get()->result();
  }

  public function get_reportCstsAll()
  {
    $this->db->select("id, dni, CONCAT(first_name, ' ',last_name) AS customer");
    $this->db->from('customers');
    $this->db->where('loan_status', 1);
    return $this->db->get()->result(); 
  }

  public function get_reportCsts($user_id)
  {
    $this->db->select("c.id, c.dni, CONCAT(c.first_name, ' ',c.last_name) AS customer");
    $this->db->from('customers c');
    $this->db->join('users u', 'u.id = c.user_id');
    $this->db->where('u.id', $user_id);
    $this->db->where('loan_status', 1);

    return $this->db->get()->result(); 
  }

  public function get_reportLCAll($customer_id)
  {
    $this->db->select("l.*, CONCAT(c.first_name, ' ', c.last_name) AS customer_name, co.short_name, co.name,
    CONCAT(u.academic_degree, ' ', u.first_name, ' ', u.last_name) AS user_name, c.dni ci");
    $this->db->from('loans l');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->join('coins co', 'co.id = l.coin_id', 'left');
    $this->db->join('users u', 'u.id = c.user_id', 'left');
    $this->db->where('l.customer_id', $customer_id);

    return $this->db->get()->result(); 
  }

  public function get_reportLC($user_id, $customer_id)
  {
    $this->db->select("l.*, CONCAT(c.first_name, ' ', c.last_name) AS customer_name, co.short_name, co.name,
    CONCAT(u.academic_degree, ' ', u.first_name, ' ', u.last_name) AS user_name, c.dni ci");
    $this->db->from('loans l');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->join('users u', 'u.id = c.user_id', 'left');
    $this->db->join('coins co', 'co.id = l.coin_id', 'left');
    $this->db->where('l.customer_id', $customer_id);
    $this->db->where('u.id', $user_id);

    return $this->db->get()->result(); 
  }

  public function get_reportLIAll($loan_id)
  {
    $this->db->where('loan_id', $loan_id);

    return $this->db->get('loan_items')->result(); 
  }

  public function get_reportLI($user_id, $loan_id)
  {
    $this->db->select('li.*');
    $this->db->from('loan_items li');
    $this->db->join('loans l', 'l.id = li.loan_id');
    $this->db->join('customers c', 'c.id = l.customer_id');
    $this->db->join('users u', 'u.id = c.user_id');
    $this->db->where('loan_id', $loan_id);
    $this->db->where('u.id', $user_id);

    return $this->db->get()->result(); 
  }

  public function get_guarantorsAll($loan_id){
    $this->db->select('c.id, CONCAT(c.first_name, " ", c.last_name) as fullname, c.dni ci');
    $this->db->from('customers c');
    $this->db->join('guarantors g', "g.customer_id = c.id");
    $this->db->join('loans l', "l.id = g.loan_id");
    $this->db->where('l.id', $loan_id);
    return $this->db->get()->result();
  }

  public function get_guarantors($user_id, $loan_id){
    $this->db->select('c.id, CONCAT(c.first_name, " ", c.last_name) as fullname, c.dni ci');
    $this->db->from('customers c');
    $this->db->join('guarantors g', "g.customer_id = c.id");
    $this->db->join('loans l', "l.id = g.loan_id");
    $this->db->where('l.id', $loan_id);
    $this->db->where('c.user_id', $user_id);
    return $this->db->get()->result();
  }

  

}

/* End of file Reports_m.php */
/* Location: ./application/models/Reports_m.php */