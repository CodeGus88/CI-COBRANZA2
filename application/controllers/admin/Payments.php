<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . "/tools/UserPermission.php");

class Payments extends CI_Controller
{

  private $user_id;
  private $permission;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('payments_m');
    $this->load->model('cashregister_m');
    $this->load->model('permission_m');
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
    $this->user_id = $this->session->userdata('user_id');
    $this->permission = new Permission($this->permission_m, $this->user_id);
  }

  public function index($user_id = 0)
  {
    $data[LOAN_UPDATE] = $this->permission->getPermission([LOAN_UPDATE], FALSE);
    $data[LOAN_ITEM_UPDATE] = $this->permission->getPermission([LOAN_ITEM_UPDATE], FALSE);
    $data[AUTHOR_LOAN_UPDATE] =  $this->permission->getPermission([AUTHOR_LOAN_UPDATE], FALSE);
    $data[AUTHOR_LOAN_ITEM_UPDATE] = $this->permission->getPermission([AUTHOR_LOAN_ITEM_UPDATE], FALSE);
    $data[LOAN_ITEM_READ] = $this->permission->getPermission([LOAN_ITEM_READ], FALSE);
    $data[AUTHOR_LOAN_ITEM_READ] = $this->permission->getPermission([AUTHOR_LOAN_ITEM_READ], FALSE);
    $data['payments'] = array();
    if ($this->permission->getPermissionX([LOAN_READ, LOAN_ITEM_READ], FALSE)) {
      $data['users'] = $this->db->get('users')->result();
      $data['selected_user_id'] = $user_id;
      if ($user_id == 0) {
        $data['payments'] = $this->payments_m->getPaymentsAll();
      } else {
        $data['payments'] = $this->payments_m->getPayments($user_id);
      }
    } elseif ($this->permission->getPermissionx([AUTHOR_LOAN_READ, AUTHOR_LOAN_ITEM_READ], FALSE)) {
      $data['payments'] = $this->payments_m->getPayments($this->user_id);
    }
    $data['subview'] = 'admin/payments/index';
    $this->load->view('admin/_main_layout', $data);
  }

  public function edit()
  {
    $customer_id = $this->input->get('customer_id') ?? NULL;
    $this->permission->redirectIfFalse(
      $this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE) || $this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE),
      TRUE
    );
    $data['default_selected_customer_id'] = $customer_id;
    $data['customers'] = array();
    if ($this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE))
      $data['customers'] = $this->payments_m->getCustomersAll();
    elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE))
      $data['customers'] = $this->payments_m->get_customers($this->user_id);
    $data['subview'] = 'admin/payments/edit';
    $this->load->view('admin/_main_layout', $data);
  }

  public function ajax_get_loan($customer_id)
  {
    if ($this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE))
      $quota_data = $this->payments_m->getLoanAll($customer_id);
    elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE))
      $quota_data = $this->payments_m->getLoan($this->user_id, $customer_id);
    $search_data = ['loan' => $quota_data];
    echo json_encode($search_data); // datos leidos por javascript Ajax
  }

  public function ajax_get_loan_items($loan_id)
  {
    $quota_data = array();
    if ($this->permission->getPermission([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE))
      $quota_data = $this->payments_m->getLoanItemsAll($loan_id);
    elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE))
      $quota_data = $this->payments_m->getLoanItems($this->user_id, $loan_id);
    $search_data = ['quotas' => $quota_data];
    echo json_encode($search_data); // datos leidos por javascript Ajax
  }

  public function ajax_get_guarantors($loan_id)
  {
    $guarantors = array();
    if ($this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE))
      $guarantors = $this->payments_m->getGuarantorsAll($loan_id);
    elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE))
      $guarantors = $this->payments_m->get_guarantors($this->user_id, $loan_id);
    $search_datax = ['guarantors' => $guarantors];
    echo json_encode($search_datax); // datos leidos por javascript Ajax
  }

  /**
   * Pagar reemplaza funcionalidad de guardar de ticket
   */
  public function save_payment()
  {
    $LOAN_UPDATE = $this->permission->getPermission([LOAN_UPDATE], FALSE);
    $LOAN_ITEM_UPDATE = $this->permission->getPermission([LOAN_ITEM_UPDATE], FALSE);
    $AUTHOR_LOAN_UPDATE = $this->permission->getPermission([AUTHOR_LOAN_UPDATE], FALSE);
    $AUTHOR_LOAN_ITEM_UPDATE = $this->permission->getPermission([AUTHOR_LOAN_ITEM_UPDATE], FALSE);
    // Guardar
    $customer_id = $this->input->post('customer_id');
    if ($customer_id != null) { // valida que no se acceda desde la url sin datos de entrada
      if ($LOAN_UPDATE && $LOAN_ITEM_UPDATE)
        $data['customerName'] = $this->payments_m->getCustomerByIdAll($customer_id);
      elseif ($AUTHOR_LOAN_UPDATE && $AUTHOR_LOAN_ITEM_UPDATE)
        $data['customerName'] = $this->payments_m->get_customer_by_id($this->user_id, $customer_id);
      $data['coin'] = $this->input->post('coin');
      $data['loan_id'] = $this->input->post('loan_id');
      $loan_id = $this->input->post('loan_id');
      $quota_id = $this->input->post('quota_id'); // array
      $cash_register_id =  $this->input->post('cash_register_id');
      // cargar pagos
      $payments = [];
      if (isset($quota_id)) : if (sizeof($quota_id) > 0) :
          foreach ($quota_id as $id) {
            array_push($payments, [
              'loan_item_id' => $id,
              'amount' => $this->input->post("amount_quota_$id"),
              'surcharge' => $this->input->post("surcharge_$id")
            ]);
          }
        endif;
      endif;
      if ($LOAN_UPDATE && $LOAN_ITEM_UPDATE) {
        $this->addPayment($loan_id, $cash_register_id, $quota_id, $payments, $customer_id, $data);
      } elseif ($AUTHOR_LOAN_UPDATE && $AUTHOR_LOAN_ITEM_UPDATE) {
        $probable_user_id = $this->payments_m->get_loan_adviser_user_id($loan_id)->id;
        if (AuthUserData::isAuthor($probable_user_id)) {
          $this->addPayment($loan_id, $cash_register_id, $quota_id, $payments, $customer_id, $data);
        } else {
          echo PERMISSION_DENIED_MESSAGE;
        }
      } else {
        echo PERMISSION_DENIED_MESSAGE;
      }
    } else {
      echo loadErrorMessage('¡Imposible acceder a está página, faltan datos de entrada para la transacción!');
    }
  }

  /**
   * Guarda los pagos
   */
  private function addPayment($loan_id, $cash_register_id, $quota_id, $payments, $customer_id)
  {
    $validate = $this->payments_m->paymentsOk($payments);
    $savePaymentsIsSuccess = FALSE;
    try {
      if ($validate->valid) {
        $this->cashRegisterValidation($loan_id, $this->user_id, $cash_register_id);
        $Object = new DateTime();
        $pay_date = $Object->format("Y-m-d h:i:s");
        $this->db->trans_begin(); // inicio de la transacción

        $id = $this->payments_m->addDocumentPayment(['user_id' => $this->user_id, 'cash_register_id' => $cash_register_id, 'pay_date' => $pay_date]);
        if ($id > 0) {
          for ($i = 0; $i < sizeof($payments); $i++) {
            $payments[$i]['document_payment_id'] = $id;
          }
          $savePaymentsIsSuccess = $this->payments_m->addPayments($payments);
        }
      } else {
        foreach ($validate->errors as $error)
          echo "ERROR: " . $error;
        return;
      }
      if ($savePaymentsIsSuccess) { // Cambiar estados
        if (isset($quota_id)) {
          foreach ($quota_id as $q) {
            if ($this->payments_m->paymentsIsEqualToQuote($q))
              $this->payments_m->update_quota(['status' => 0], $q);
          }
          if (!$this->payments_m->check_cstLoan($loan_id)) {
            $this->payments_m->update_cstLoan($loan_id, $customer_id);
          }
          $this->db->trans_commit();
          if ($this->permission->getPermission([DOCUMENT_PAYMENT_READ, AUTHOR_DOCUMENT_PAYMENT_READ], FALSE))
            redirect("admin/payments/document_payment/$id");
          else {
            $this->session->set_flashdata('msg', 'El pago se procesó con éxito');
            redirect("admin/payments");
          }
        } else {
          $this->db->trans_rollback();
          $this->session->set_flashdata('msg_error', 'No existen cuotas para registrar');
        }
      } else {
        $this->db->trans_rollback();
        $this->session->set_flashdata('msg_error', '¡Ocurrió un error durante la transacción!');
      }
      redirect("admin/payments/edit");
    } catch (Exception $ex) {
      $this->db->trans_rollback();
      echo loadErrorMessage($ex->getMessage());
    }
  }

  private function cashRegisterValidation($loan_id, $user_id, $cash_register_id)
  {
    $errors = [];
    if ($this->cashregister_m->isAuthor($cash_register_id, $user_id)) {
      $loanRequest = $this->db->get_where('loans', ['id' => $loan_id])->row();
      $coin_id = $loanRequest->coin_id??0;
      if (!$this->cashregister_m->isCoinType($cash_register_id, $coin_id))
        array_push($errors, 'El tipo de moneda del préstamo, no coincide con el tipo de moneda de la caja');
      if (!$this->cashregister_m->isOpen($cash_register_id))
        array_push($errors, 'La caja está cerrada');
    }else{
      array_push($errors, 'El usuario no es autor de la caja o la caja no existe');
    }
    if(sizeof($errors) > 0){
      $messages = '';
      foreach($errors as $error)
        $messages .= '<li>'.$error .'</li>';;
      $this->session->set_flashdata('msg_error', $messages);
      redirect("admin/payments/edit");
    } 
  }

  public function document_payment($id)
  {
    $document = $this->payments_m->getDocumentPayment($id);
    if ($this->permission->getPermission([DOCUMENT_PAYMENT_READ], FALSE)) {
      $this->load->view('admin/payments/ticket', $document);
      return;
    } elseif ($this->permission->getPermission([AUTHOR_DOCUMENT_PAYMENT_READ], FALSE)) {
      if ($document['customer']->user_id == $this->user_id) {
        $this->load->view('admin/payments/ticket', $document);
        return;
      }
    }
    echo loadErrorMessage('No tiene el permiso para leer el documento de impresión...');
  }

  /**
   * Muestra las cuotas proximas y las que ya están con mora
   * https://www.delftstack.com/es/howto/php/how-to-get-the-current-date-and-time-in-php/
   * https://www.php.net/manual/en/timezones.america.php
   */
  function quotes_week($user_id = 0)
  {
    $start_date = date("Y-m-d", time());
    $end_date = date("Y-m-d", strtotime($start_date . ' + 7 days'));
    if ($this->permission->getPermission([LOAN_ITEM_READ], FALSE)) {
      if ($user_id == 0) {
        $data['user_name'] = "TODOS";
        $request = $this->payments_m->quotesWeekAll($start_date, $end_date);
      } else {
        $data['user_name'] = $this->payments_m->getUser($user_id)->user_name;
        $request = $this->payments_m->quotesWeek($user_id, $start_date, $end_date);
      }
      $data['items'] = $request['items'];
      $data['payables'] = $request['payables'];
      $data['payable_expired'] = $request['payable_expired'];
      $data['payable_now'] = $request['payable_now'];
      $data['payable_next'] = $request['payable_next'];
    } elseif ($this->permission->getPermission([AUTHOR_LOAN_ITEM_READ], FALSE)) {
      $request = $this->payments_m->quotesWeek($this->user_id, $start_date, $end_date);
      $data['user_name'] = $this->payments_m->getUser($this->user_id)->user_name;
      $data['items'] = $request['items'];
      $data['payables'] = $request['payables'];
      $data['payable_expired'] = $request['payable_expired'];
      $data['payable_now'] = $request['payable_now'];
      $data['payable_next'] = $request['payable_next'];
    } else {
      $data['user_name'] = '';
      $data['items'] = [];
      $data['payables'] = null;
      $data['payable_expired'] = null;
      $data['payable_now'] = null;
      $data['payable_next'] = null;
    }
    $this->load->view('admin/payments/quotes_week', $data);
  }

  public function ajax_get_cash_registers($coin_id)
  {
    if ($this->permission->getPermission([CASH_REGISTER_READ, AUTHOR_CASH_REGISTER_READ], FALSE))
      echo json_encode($this->cashregister_m->getCashRegistersX($this->user_id, $coin_id));
    else
      echo json_encode([]);
  }
}

/* End of file Payments.php */
/* Location: ./application/controllers/admin/Payments.php */