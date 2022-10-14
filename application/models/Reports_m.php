<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_m extends CI_Model {

  public function getReportLoanAll($coin_id, $start_date, $end_date)
  { // Total crédito
    $this->db->select('c.short_name, sum(l.credit_amount) as sum_credit');
    $this->db->join('coins c', 'c.id = l.coin_id', 'left');
    $this->db->where('l.coin_id', $coin_id);
    $this->db->where("l.date BETWEEN '{$start_date}' AND '{$end_date}'");
    $cr = $this->db->get('loans l')->row();
    // Total crédito con interés
    $this->db->select('c.short_name, sum(TRUNCATE(l.fee_amount * num_fee,2)) AS cr_interest');
    $this->db->join('coins c', 'c.id = l.coin_id', 'left');
    $this->db->where('l.coin_id', $coin_id);
    $this->db->where("l.date BETWEEN '{$start_date}' AND '{$end_date}'");
    $cr_interest = $this->db->get('loans l')->row();
    // Total crédito cancelado con interés
    $this->db->select('c.short_name, sum(TRUNCATE(l.fee_amount * num_fee,2)) AS cr_interestPaid');
    $this->db->join('coins c', 'c.id = l.coin_id', 'left');
    $this->db->where(['l.coin_id' => $coin_id, 'l.status' => 0]);
    $this->db->where("l.date BETWEEN '{$start_date}' AND '{$end_date}'");
    $cr_interestPaid = $this->db->get('loans l')->row();
    // Total crédito por cobrar con interés
    $this->db->select('c.short_name, sum(TRUNCATE(l.fee_amount * num_fee,2)) AS cr_interestPay');
    $this->db->join('coins c', 'c.id = l.coin_id', 'left');
    $this->db->where(['l.coin_id' => $coin_id, 'l.status' => 1]);
    $this->db->where("l.date BETWEEN '{$start_date}' AND '{$end_date}'");
    $cr_interestPay = $this->db->get('loans l')->row();
    // total cuotas cobrables
    $this->db->select("co.short_name, SUM(li.fee_amount) as payable");
    $this->db->from("loans l");
    $this->db->join("coins co", "co.id = l.coin_id");
    $this->db->join("loan_items li", "li.loan_id = l.id");
    $this->db->where("li.date BETWEEN '{$start_date}' AND '{$end_date}'");
    $payable = $this->db->get()->row();
    // Total pagos cobrado
    $this->db->select('co.short_name, IFNULL(SUM(IFNULL(p.mount, li.fee_amount)),0) AS mount_payed');
    $this->db->from('loans l');
    $this->db->join('coins co', 'co.id = l.coin_id');
    $this->db->join('loan_items li', 'li.loan_id = l.id');
    $this->db->join('payments p', 'p.loan_item_id = li.id', 'left');
    $this->db->join('document_payments dp', 'dp.id = p.document_payment_id', 'left');
    $this->db->where("( (li.status = FALSE AND li.pay_date BETWEEN '{$start_date}' AND '{$end_date} 23:59:59') OR 
    (li.status = TRUE AND  EXISTS(SELECT * FROM payments py WHERE py.loan_item_id = li.id) AND dp.pay_date BETWEEN '{$start_date}' AND '{$end_date} 23:59:59') )");
    $this->db->where("co.id", $coin_id);
    $mount_payed = $this->db->get()->row();

    $credits = [$cr, $cr_interest, $cr_interestPaid, $cr_interestPay, $mount_payed, $payable];

    return $credits;
  }

  public function get_reportLoan($user_id, $coin_id, $start_date, $end_date)
  {
    $this->db->select('c.short_name, sum(l.credit_amount) as sum_credit');
    $this->db->join('coins c', 'c.id = l.coin_id');
    $this->db->join('customers cu', 'cu.id = l.customer_id');
    $this->db->join('users u', 'u.id = cu.user_id');
    $this->db->where('l.coin_id', $coin_id);
    $this->db->where("l.date BETWEEN '{$start_date}' AND '{$end_date}'");
    $this->db->where('u.id', $user_id);
    $cr = $this->db->get('loans l')->row();

    $this->db->select('c.short_name, sum(TRUNCATE(l.fee_amount * num_fee,2)) AS cr_interest');
    $this->db->join('coins c', 'c.id = l.coin_id');
    $this->db->join('customers cu', 'cu.id = l.customer_id');
    $this->db->join('users u', 'u.id = cu.user_id');
    $this->db->where('l.coin_id', $coin_id);
    $this->db->where("l.date BETWEEN '{$start_date}' AND '{$end_date}'");
    $this->db->where('u.id', $user_id);
    $cr_interest = $this->db->get('loans l')->row();

    $this->db->select('c.short_name, sum(TRUNCATE(l.fee_amount * num_fee,2)) AS cr_interestPaid');
    $this->db->join('coins c', 'c.id = l.coin_id');
    $this->db->join('customers cu', 'cu.id = l.customer_id');
    $this->db->join('users u', 'u.id = cu.user_id');
    $this->db->where(['l.coin_id' => $coin_id, 'l.status' => 0]);
    $this->db->where("l.date BETWEEN '{$start_date}' AND '{$end_date}'");
    $this->db->where('u.id', $user_id);
    $cr_interestPaid = $this->db->get('loans l')->row();

    $this->db->select('c.short_name, sum(TRUNCATE(l.fee_amount * num_fee,2)) AS cr_interestPay');
    $this->db->join('coins c', 'c.id = l.coin_id');
    $this->db->join('customers cu', 'cu.id = l.customer_id');
    $this->db->join('users u', 'u.id = cu.user_id');
    $this->db->where(['l.coin_id' => $coin_id, 'l.status' => 1]);
    $this->db->where("l.date BETWEEN '{$start_date}' AND '{$end_date}'");
    $this->db->where('u.id', $user_id);
    $cr_interestPay = $this->db->get('loans l')->row();
    // total cuotas cobrables del usuario
    $this->db->select("co.short_name, SUM(li.fee_amount) as payable");
    $this->db->from("loans l");
    $this->db->join("customers c", "c.id = l.customer_id");
    $this->db->join("coins co", "co.id = l.coin_id");
    $this->db->join("loan_items li", "li.loan_id = l.id");
    $this->db->where("c.user_id", $user_id);
    $this->db->where("(li.date BETWEEN '{$start_date}' AND '{$end_date}')");
    $payable = $this->db->get()->row();
    // Total monto cobrado 
    $this->db->select('co.short_name, IFNULL(SUM(IFNULL(p.mount, li.fee_amount)),0) AS mount_payed');
    $this->db->from('loans l');
    $this->db->join('coins co', 'co.id = l.coin_id');
    $this->db->join('customers c', 'c.id = l.customer_id');
    $this->db->join('loan_items li', 'li.loan_id = l.id');
    $this->db->join('payments p', 'p.loan_item_id = li.id', 'left');
    $this->db->join('document_payments dp', 'dp.id = p.document_payment_id', 'left');
    $this->db->where("( (li.status = FALSE AND li.pay_date BETWEEN '{$start_date}' AND '{$end_date}  23:59:59') OR 
    (li.status = TRUE AND  EXISTS(SELECT * FROM payments py WHERE py.loan_item_id = li.id) AND dp.pay_date BETWEEN '{$start_date}' AND '{$end_date}  23:59:59') )");
    $this->db->where("c.user_id", $user_id);
    $this->db->where("co.id", $coin_id);
    $mount_payed = $this->db->get()->row();

    $credits = [$cr, $cr_interest, $cr_interestPaid, $cr_interestPay, $mount_payed, $payable];

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
    $subquery = "(SELECT IFNULL(SUM(p.mount), 0) FROM payments p WHERE p.loan_item_id = li.id )";
    $this->db->select("li.*,  $subquery payed");
    $this->db->where('loan_id', $loan_id);
    return $this->db->get('loan_items li')->result(); 
  }

  public function get_reportLI($user_id, $loan_id)
  {
    $subquery = "(SELECT IFNULL(SUM(p.mount), 0) FROM payments p WHERE p.loan_item_id = li.id )";
    $this->db->select("li.*,  $subquery payed");
    $this->db->join('loans l', 'l.id = li.loan_id');
    $this->db->join('customers c', 'c.id = l.customer_id');
    $this->db->join('users u', 'u.id = c.user_id');
    $this->db->where('loan_id', $loan_id);
    $this->db->where('u.id', $user_id);

    return $this->db->get('loan_items li')->result(); 
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

  public function getUser($user_id){
    $this->db->select("CONCAT(u.academic_degree, ' ', u.first_name, ' ', u.last_name) as user_name");
    $this->db->from('users u');
    $this->db->where('id', $user_id);
    return $this->db->get()->row();
  }

}

/* End of file Reports_m.php */
/* Location: ./application/models/Reports_m.php */