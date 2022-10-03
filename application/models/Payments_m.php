<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments_m extends CI_Model {
  
  public function getPaymentsAll()
  {
    $this->db->select("li.id, c.dni, concat(c.first_name,' ',c.last_name) AS name_cst, l.id AS loan_id, li.pay_date, li.num_quota, li.fee_amount");
    $this->db->from('loan_items li');
    $this->db->join('loans l', 'l.id = li.loan_id', 'left');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->join('users u', 'u.id = c.user_id', 'left');
    $this->db->where('li.status', 0);
    $this->db->order_by('li.pay_date', 'desc');
    return $this->db->get()->result();
  }

  public function getPayments($user_id)
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

  public function getCustomersAll(){
    $this->db->select("c.id, c.dni, CONCAT(c.first_name, ' ', c.last_name) as fullname");
    $this->db->from('customers c');
    $this->db->where("c.loan_status = TRUE");
    return $this->db->get()->result();
  }

  public function get_customers($user_id){
    $this->db->select("c.id, c.dni, CONCAT(c.first_name, ' ', c.last_name) as fullname");
    $this->db->from('customers c');
    $this->db->where("c.user_id = $user_id");
    $this->db->where("c.loan_status = TRUE");
    return $this->db->get()->result();
  }

  public function getLoanAll($customer_id)
  {
    $this->db->select("l.id, l.customer_id, l.credit_amount, l.payment_m, co.name as coin_name, CONCAT(u.academic_degree, ' ', u.first_name, ' ', u.last_name) as user_name");
    $this->db->from('loans l');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->join('users u', 'u.id = c.user_id', 'left');
    $this->db->join('coins co', 'co.id = l.coin_id', 'left');
    $this->db->where(['c.loan_status' => 1, 'l.status' => 1, 'c.id' => $customer_id]);
    return $this->db->get()->row();
  }

  public function get_loan($user_id, $customer_id)
  {
    $this->db->select("l.id, l.customer_id, l.credit_amount, l.payment_m, co.name as coin_name, CONCAT(u.academic_degree, ' ', u.first_name, ' ', u.last_name) as user_name");
    $this->db->from('loans l');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->join('users u', 'u.id = c.user_id', 'left');
    $this->db->join('coins co', 'co.id = l.coin_id', 'left');
    $this->db->where(['c.loan_status' => 1, 'l.status' => 1, 'c.id' => $customer_id]);
    $this->db->where("u.id", $user_id);
    return $this->db->get()->row();
  }

  public function getLoanItemsAll($loan_id)
  {

    $this->db->select("li.*, (select SUM(p.mount) FROM payments p WHERE p.loan_item_id = li.id) payed");
    $this->db->from('loan_items li');
    $this->db->join('loans l', 'l.id = li.loan_id');
    $this->db->join('customers c', 'c.id = l.customer_id');
    $this->db->join('users u', 'u.id = c.user_id');
    $this->db->join('coins co', 'co.id = l.coin_id');
    $this->db->where("l.id", $loan_id);
    return $this->db->get()->result();

    // $this->db->select("li.*");
    // $this->db->from('loan_items li');
    // $this->db->join('loans l', 'l.id = li.loan_id');
    // $this->db->join('customers c', 'c.id = l.customer_id');
    // $this->db->join('users u', 'u.id = c.user_id');
    // $this->db->join('coins co', 'co.id = l.coin_id');
    // $this->db->where("l.id", $loan_id);
    // return $this->db->get()->result();
  }

  public function get_loan_items($user_id, $loan_id)
  {
    $this->db->select("li.*, (select SUM(p.mount) FROM payments p WHERE p.loan_item_id = li.id) payed");
    $this->db->from('loan_items li');
    $this->db->join('loans l', 'l.id = li.loan_id');
    $this->db->join('customers c', 'c.id = l.customer_id');
    $this->db->join('users u', 'u.id = c.user_id');
    $this->db->join('coins co', 'co.id = l.coin_id');
    $this->db->where("l.id", $loan_id);
    $this->db->where("u.id", $user_id);
    return $this->db->get()->result();
  }

  public function update_quota($data, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('loan_items', $data); 
  }

  public function check_cstLoan($loan_id)
  {
    $request = $this->db->select('COUNT(*) count')
      ->from('loan_items')
      ->where('loan_id', $loan_id)
      ->where('status', TRUE)
      ->get()->row();
    // echo "Cantidad de cuotas disponibles: " . $request->count ."<br>";
    return ($request->count > 0)?TRUE: FALSE;

    // $this->db->where('loan_id', $loan_id);
    // $query = $this->db->get('loan_items'); 
    // $check = false;
    // foreach ($query->result() as $row) {
    //   if ($row->status == 1) {
    //     $check = true;
    //     break;
    //   } 
    // }
    // return $check;
  }

  /**
   * Verifica si ya se completó de pagar una cuata con los pagos
   */
  public function paymentsIsEqualToQuote($loan_item_id){
    $paidRequest = $this->db
      ->select('SUM(p.mount) total_quota')
      ->where('loan_item_id', $loan_item_id)
      ->get('payments p')
      ->row();
    $paid = ($paidRequest->total_quota)?$paidRequest->total_quota:0;
    $quotaRequest = $this->db
      ->select('li.fee_amount')
      ->where('id', $loan_item_id)
      ->get('loan_items li')
      ->row();
    $quota = ($quotaRequest->fee_amount)?$quotaRequest->fee_amount:0;
    echo "paid: " . $paid ."<br>";
    echo "quota: " . $quota ."<br>";
    echo "¿Todo saldado?" . (($paid>=$quota)?'TRUE':'FALSE') ."<br>";
    echo "<hr>";
    return ($paid >= $quota)?TRUE:FALSE;
  }

  public function addPayments($payments){
    try{
      foreach($payments as $payment){
        $this->db->insert('payments', $payment);
      }
      return true;
    }catch(Exception $e){
      echo ($e->getMessage());
      return false;
    }
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

  public function getGuarantorsAll($loan_id){
    $this->db->select("g.id, c.dni ci, CONCAT(c.first_name, ' ', c.last_name) guarantor_name");
    $this->db->from('customers c');
    $this->db->join('guarantors g', 'g.customer_id = c.id');
    $this->db->where(['g.loan_id'=>$loan_id]);
    return $this->db->get()->result();
  }

  public function get_guarantors($user_id, $loan_id){
    $this->db->select("g.id, c.dni ci, CONCAT(c.first_name, ' ', c.last_name) guarantor_name");
    $this->db->from('customers c');
    $this->db->join('guarantors g', 'g.customer_id = c.id');
    $this->db->where(['g.loan_id'=>$loan_id, 'c.user_id'=>$user_id]);
    return $this->db->get()->result();
  }

  public function getCustomerByIdAll($customer_id){
    $this->db->select("CONCAT(c.first_name, ' ', c.last_name) customer_name")
              ->from('customers c')
              ->where('c.id', $customer_id);
    return $this->db->get()->row();
  }

  public function get_customer_by_id($user_id, $customer_id){
    $this->db->select("CONCAT(c.first_name, ' ', c.last_name) customer_name")
              ->from('customers c')
              ->join('users u', 'u.id = c.user_id')
              ->where('u.id', $user_id)
              ->where('c.id', $customer_id);
    return $this->db->get()->row();
  }

  public function getCustomerAdvisorName($customer_id){
    $this->db->select("CONCAT(u.academic_degree, ' ', u.first_name, ' ', u.last_name) user_name");
    $this->db->from('users u');
    $this->db->join('customers c', 'c.user_id = u.id');
    $this->db->where('c.id', $customer_id);
    return $this->db->get()->row();
  }

  /**
   * Valida si permite guardar o no el registro de pagos
   * Si payment es > a 0, continuar (ok)
   * Si el estado de loan_item está true, continuar (ok)
   * Si payment <= a la deuda, continuar;
   */
  public function paymentsOk($payments){
    $success = new stdClass();
    $success->errors = [];
    $success->valid = TRUE;
    try{
      foreach($payments as $item){
        // Si payment es > a 0, continuar (ok)
        if($item['mount'] <= 0)
          array_push($success->errors, 'payments.mount <= 0');
        // Si payment es mayor a 0, continuar (ok)
        $loan_item_status = $this->db->select('status')->where('id', $item["loan_item_id"])->get('loan_items')->row();
        if($loan_item_status->status == FALSE)
          array_push($success->errors, 'loan_items.status is FALSE');
        // Si payment <= a la deuda, continuar;
        $paid_request = $this->db->select("SUM(p.mount) AS debt")->where('loan_item_id', $item['loan_item_id'])->get('payments p')->row(); // deuda
        $mount_request = $this->db->select('li.fee_amount')->where('id',$item['loan_item_id'])->get('loan_items li')->row();
        $paid = isset($paid_request->debt)?$paid_request->debt:0;
        $mount = isset($mount_request->fee_amount)?$mount_request->fee_amount:0;
        $debt = round($mount - $paid, 2); // mostraba con muchos decimales
        if($item['mount'] > $debt)
          array_push($success->errors, "payments.mount > debt ($mount > $debt)");
        if(sizeof($success->errors) > 0)
          $success->valid = FALSE;
        return $success;
      }
    }catch(Exception $e){
      $success->valid = FALSE;
      array_push($success->errors, $e->getMessage());
      return $success;
    }
  }

}

/* End of file Payments_m.php */
/* Location: ./application/models/Payments_m.php */