<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashRegister_m extends MY_Model {

  protected $_table_name = 'cash_registers';

  public $rules = array(
    array(
      'field' => 'name',
      'label' => 'nombre',
      'rules' => 'trim|required|is_unique[cash_registers.name]',
    ),
    array(
      'field' => 'coin_id',
      'label' => 'tipo de moneda',
      'rules' => 'trim|required',
    ),
    array(
      'field' => 'amount',
      'label' => 'monto',
      'rules' => 'numeric|is_natural_no_zero|required',
    )
  );

  public function getLastId()
  {
    $obj = $this->db->select("IFNULL(MAX(id), 0) id")
    ->get('cash_registers')->row();
    return $obj;
  }

  public function isAuthor($cash_register_id, $user_id)
  {
    $this->db->select("IF( EXISTS(
      SELECT *
      FROM cash_registers cr
      WHERE cr.id = $cash_register_id AND cr.user_id = $user_id), 1, 0) exist");
    return $this->db->get()->row()->exist==1?TRUE:FALSE;
  }

  public function getCashRegisters($start, $length, $search, $order, $user_id)
  {
    $this->db->select("COUNT(IFNULL(cr.id, 0)) recordsFiltered");
    $this->db->from('cash_registers cr');
    $this->db->join('users u', 'u.id = cr.user_id');
    if($user_id == 'all') $user_condition = "";
    else $user_condition = "AND u.id = $user_id";
    $this->db->where("(cr.opening_date LIKE '%$search%' OR cr.closing_date LIKE '%$search%' 
    OR  CONCAT_WS(' ', u.first_name, u.last_name) LIKE '%$search%') $user_condition");
    $data['recordsFiltered'] = $this->db->get()->row()->recordsFiltered??0;
    
    $manualInput = "IFNULL((
      SELECT SUM(IFNULL(mi.amount, 0)) 
      FROM manual_inputs mi
      WHERE mi.cash_register_id = cr.id
    ), 0)";
    $paymentsInputs = "IFNULL((
      SELECT SUM( IFNULL(p.amount, 0) + IFNULL(p.surcharge, 0))
      FROM document_payment_inputs dpi
      LEFT JOIN document_payments dp ON dpi.document_payment_id = dp.id
      LEFT JOIN payments p ON dp.id = p.document_payment_id
      WHERE dpi.cash_register_id = cr.id
    ), 0)";
    $manualOutputs = "IFNULL((
      SELECT SUM(IFNULL(mo.amount, 0)) 
      FROM manual_outputs mo
      WHERE mo.cash_register_id = cr.id
    ), 0)";
    $loanOutputs = "IFNULL((
      SELECT SUM(IFNULL(l.credit_amount, 0)) 
      FROM loan_outputs lo
      LEFT JOIN  loans l ON l.id = lo.loan_id
      WHERE lo.cash_register_id = cr.id
    ), 0)";
    $this->db->select("cr.*, c.short_name,( ($manualInput + $paymentsInputs) - ($manualOutputs + $loanOutputs) )  total_amount, 
    CONCAT_WS(' ', u.first_name, u.last_name) user_name");
    $this->db->from('cash_registers cr');
    $this->db->join('users u', 'u.id = cr.user_id');
    $this->db->join('coins c', 'c.id = cr.coin_id', 'left');
    if($user_id == 'all') $user_condition = "";
    else $user_condition = "AND u.id = $user_id";
    $this->db->where("(cr.opening_date LIKE '%$search%' OR cr.closing_date LIKE '%$search%' 
    OR  CONCAT_WS(' ', u.first_name, u.last_name) LIKE '%$search%') $user_condition");
    $this->db->limit($length, $start);
    if($order['column'] != 'name')
      $this->db->order_by($order['column'], $order['dir']);
    else{
      $this->db->order_by("LENGTH(cr.name)", $order['dir']);
      $this->db->order_by("cr.name", $order['dir']);
    }
    $data['data'] = $this->db->get()->result()??[];
    return $data;
  }

  /**
   * Obtiene los datos de la caja
   */
  public function getCashRegister($cash_register_id)
  {
    $manualInputsAmount = $this->getManualInputsByCashRegisterId($cash_register_id);
    $manualOutputsAmount = $this->getManualOutputsByCashRegisterId($cash_register_id);
    $loanOutputsAmount = $this->getLoanOutputsByCashRegisterId($cash_register_id);
    $documentPaymentInputsAmount = $this->getDocumentPaymentInputsByCashRegisterId($cash_register_id);
    $this->db->select("cr.*, c.name coin_name, c.short_name, c.symbol, CONCAT_WS(' ', u.academic_degree, u.first_name, u.last_name) user_name, 
    ($manualInputsAmount) manual_inputs_amount, ($manualOutputsAmount) manual_outputs_amount, 
    ($loanOutputsAmount) loan_outputs_amount, ($documentPaymentInputsAmount) document_payment_inputs_amount");
    $this->db->from('cash_registers cr');
    $this->db->join('users u', 'u.id = cr.user_id', 'left');
    $this->db->join('coins c', 'c.id = cr.coin_id', 'left');
    $this->db->where('cr.id', $cash_register_id);
    return $this->db->get()->row()??[];
  }

  /**
   * Obtiene los items de entradas manuales de una caja
   */
  public function getManualInputItems($start, $length, $search, $order, $cash_register_id)
  {
    $this->db->select("COUNT(IFNULL(mi.id, 0)) recordsFiltered");
    $this->db->from('manual_inputs mi');
    $this->db->where('mi.cash_register_id', $cash_register_id);
    $this->db->where("(mi.id LIKE '%$search%' OR mi.amount LIKE '%$search%' 
    OR  mi.date LIKE '%$search%' OR mi.description LIKE '%$search%')");
    $data['recordsFiltered'] = $this->db->get()->row()->recordsFiltered??0;

    $this->db->select('mi.id, FORMAT(mi.amount, 2) amount,  mi.description, mi.date');
    $this->db->from('manual_inputs mi');
    $this->db->where('mi.cash_register_id', $cash_register_id);
    $this->db->where("(mi.id LIKE '%$search%' OR mi.amount LIKE '%$search%' 
    OR  mi.date LIKE '%$search%' OR mi.description LIKE '%$search%')");
    $this->db->limit($length, $start);
    $this->db->order_by($order['column'], $order['dir']);
    $data['data'] = $this->db->get()->result()??[];

    return $data;
  }

  /**
   * Obtiene los items de la tabla entradas por pagos de una caja
   */
  public function getDocumentPaymentInputItems($start, $length, $search, $order, $cash_register_id)
  {
    $artifice = "(
      SELECT SUM(IFNULL(py.amount, 0) + IFNULL(py.surcharge, 0)) amount 
      FROM document_payments dpy 
      LEFT JOIN payments py ON py.document_payment_id = dpy.id
      WHERE dpy.id = dp.id
    )";
    $this->db->select("COUNT(IFNULL(dpi.id, 0)) recordsFiltered");
    $this->db->from('document_payment_inputs dpi');
    $this->db->join('document_payments dp', 'dp.id = dpi.document_payment_id', 'left');
    $this->db->join('payments p', 'p.document_payment_id = dp.id', 'left');
    $this->db->join('loan_items li', 'li.id = p.loan_item_id', 'left');
    $this->db->join('loans l', 'l.id = li.loan_id', 'left');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->where('dpi.cash_register_id', $cash_register_id);
    $this->db->where("( p.id LIKE '%$search%' OR CONCAT_WS(' ', c.first_name, c.last_name) LIKE '%$search%' 
    OR $artifice LIKE '%$search%')");
    $this->db->group_by('p.document_payment_id');
    $data['recordsFiltered'] = $this->db->get()->row()->recordsFiltered??0;

    $this->db->select("dp.id, CONCAT_WS(' ', c.first_name, c.last_name) customer_name, 
    FORMAT(SUM(IFNULL(p.amount, 0) + IFNULL(p.surcharge, 0)), 2) amount, dp.pay_date");
    $this->db->from('document_payment_inputs dpi');
    $this->db->join('document_payments dp', 'dp.id = dpi.document_payment_id', 'left');
    $this->db->join('payments p', 'p.document_payment_id = dp.id', 'left');
    $this->db->join('loan_items li', 'li.id = p.loan_item_id', 'left');
    $this->db->join('loans l', 'l.id = li.loan_id', 'left');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->where('dpi.cash_register_id', $cash_register_id);
    $this->db->where("( dp.id LIKE '%$search%' OR CONCAT_WS(' ', c.first_name, c.last_name) LIKE '%$search%' 
    OR $artifice LIKE '%$search%')");
    $this->db->group_by('p.document_payment_id');
    $this->db->order_by($order['column'], $order['dir']);
    $this->db->limit($length, $start);

    $data['data'] = $this->db->get()->result()??[];
    return $data;
  }

  /**
   * Obtiene los items de salidas manuales de una caja
   */
  public function getManualOutputItems($start, $length, $search, $order, $cash_register_id)
  {
    $this->db->select("COUNT(IFNULL(mo.id, 0)) recordsFiltered");
    $this->db->from('manual_outputs mo');
    $this->db->where('mo.cash_register_id', $cash_register_id);
    $this->db->where("(mo.id LIKE '%$search%' OR mo.amount LIKE '%$search%' 
    OR  mo.date LIKE '%$search%' OR mo.description LIKE '%$search%')");
    $data['recordsFiltered'] = $this->db->get()->row()->recordsFiltered??0;

    $this->db->select("mo.id, FORMAT(mo.amount, 2) amount,  mo.description, mo.date");
    $this->db->from('manual_outputs mo');
    $this->db->where('mo.cash_register_id', $cash_register_id);
    $this->db->where("(mo.id LIKE '%$search%' OR mo.amount LIKE '%$search%' 
    OR  mo.date LIKE '%$search%' OR mo.description LIKE '%$search%')");
    $this->db->limit($length, $start);
    $this->db->order_by($order['column'], $order['dir']);
    $data['data'] = $this->db->get()->result()??[];

    return $data;
  }

  public function getLoanOutputItems($start, $length, $search, $order, $cash_register_id)
  {
    $this->db->select("COUNT(*) recordsFiltered");
    $this->db->from('loan_outputs lo');
    $this->db->join('loans l', 'l.id = lo.loan_id', 'left');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->where('lo.cash_register_id', $cash_register_id);
    $this->db->where("(l.id LIKE '%$search%' OR l.credit_amount LIKE '%$search%' 
    OR  CONCAT_WS(' ', c.first_name, c.last_name) LIKE '%$search%' OR l.date LIKE '%$search%')");
    $data['recordsFiltered'] = $this->db->get()->row()->recordsFiltered??0;

    $this->db->select("l.id, FORMAT(l.credit_amount, 2) credit_amount, CONCAT_WS(' ', c.first_name, c.last_name) customer_name, l.date");
    $this->db->from('loan_outputs lo');
    $this->db->join('loans l', 'l.id = lo.loan_id', 'left');
    $this->db->join('customers c', 'c.id = l.customer_id', 'left');
    $this->db->where('lo.cash_register_id', $cash_register_id);
    $this->db->where("(l.id LIKE '%$search%' OR l.credit_amount LIKE '%$search%' 
    OR  CONCAT_WS(' ', c.first_name, c.last_name) LIKE '%$search%' OR l.date LIKE '%$search%')");
    $this->db->limit($length, $start);
    $this->db->order_by($order['column'], $order['dir']);
    $data['data'] = $this->db->get()->result()??[];

    return $data;
  }

  /**
   * Obtiene el total de ingresos manuales en una caja
   */
  public function getManualInputsByCashRegisterId($cash_register_id)
  {
    $this->db->select("IFNULL(SUM(IFNULL(mi.amount,0)), 0) amount");
    $this->db->from("manual_inputs mi");
    $this->db->where("mi.cash_register_id", $cash_register_id);
    return $this->db->get()->row()->amount;
  }

  /**
   * Obtiene el total de egresos manuales en una caja
   */
  public function getManualOutputsByCashRegisterId($cash_register_id)
  {
    $this->db->select("IFNULL(SUM(IFNULL(mo.amount,0)), 0) amount");
    $this->db->from("manual_outputs mo");
    $this->db->where("mo.cash_register_id", $cash_register_id);
    return $this->db->get()->row()->amount??0;
  }

  /**
   * Obtiene el total de egresos manuales por prestamos
   */
  public function getLoanOutputsByCashRegisterId($cash_register_id)
  {
    $this->db->select("IFNULL(SUM(IFNULL(l.credit_amount, 0)), 0) amount");
    $this->db->from('loan_outputs lo');
    $this->db->join('loans l', 'l.id = lo.loan_id', 'left');
    $this->db->where('lo.cash_register_id', $cash_register_id);
    return $this->db->get()->row()->amount??0;
  }

  /**
   * Obtiene el total de indresos por pagos
   */
  public function getDocumentPaymentInputsByCashRegisterId($cash_register_id)
  {
    $this->db->select("IFNULL(SUM(IFNULL(p.amount, 0) + IFNULL(p.surcharge, 0)), 0) amount");
    $this->db->from("document_payment_inputs dpi");
    $this->db->join('document_payments dp', 'dp.id = dpi.document_payment_id', 'left');
    $this->db->join('payments p', 'p.document_payment_id = dp.id', 'left');
    $this->db->where('dpi.cash_register_id', $cash_register_id);
    return $this->db->get()->row()->amount??0;
  }

  /**
   * Obtiene el total (ingresos - egresos)
   */
  public function getTotal($cash_register_id)
  {
    $inputs = $this->getManualInputsByCashRegisterId($cash_register_id) + $this->getDocumentPaymentInputsByCashRegisterId($cash_register_id);
    $outputs = $this->getManualOutputsByCashRegisterId($cash_register_id) + $this->getLoanOutputsByCashRegisterId($cash_register_id);
    $total = $inputs - $outputs;
    return $total;
  }

  public function cashRegisterInsert($data)
  {
    if ($this->db->insert('cash_registers', $data))
      return $this->db->insert_id();
    else
      return 0;
  }

  public function manualInputInsert($data)
  {
    return $this->db->insert('manual_inputs', $data);
  }

}

/* End of file Coins_m.php */
/* Location: ./application/models/Coins_m.php */