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
    $this->load->model('permission_m');
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->session->userdata('loggedin') == TRUE || redirect('user/login');
    $this->user_id = $this->session->userdata('user_id');
    $this->permission = new Permission($this->permission_m, $this->user_id);
  }

  public function index($user_id = 0)
  {
    $data[LOAN_UPDATE] =  $this->permission->getPermission([LOAN_UPDATE], FALSE);
    $data[LOAN_ITEM_UPDATE] = $this->permission->getPermission([LOAN_ITEM_UPDATE], FALSE);
    $data[AUTHOR_LOAN_UPDATE] =  $this->permission->getPermission([AUTHOR_LOAN_UPDATE], FALSE);
    $data[AUTHOR_LOAN_ITEM_UPDATE] = $this->permission->getPermission([AUTHOR_LOAN_ITEM_UPDATE], FALSE);
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
    $this->permission->redirectIfFalse(
      $this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE) || $this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE),
      TRUE
    );
    $data['customers'] = array();
    if ($this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE))
      $data['customers'] = $this->payments_m->getCustomersAll();
    elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE))
      $data['customers'] = $this->payments_m->get_customers($this->user_id);
    $data['subview'] = 'admin/payments/edit';
    $this->load->view('admin/_main_layout', $data);
  }

  function ajax_get_loan($customer_id)
  {
    if ($this->permission->getPermissionX([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE))
      $quota_data = $this->payments_m->getLoanAll($customer_id);
    elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE))
      $quota_data = $this->payments_m->get_loan($this->user_id, $customer_id);
    $search_data = ['loan' => $quota_data];
    echo json_encode($search_data); // datos leidos por javascript Ajax
  }

  function ajax_get_loan_items($loan_id)
  {
    $quota_data = array();
    if ($this->permission->getPermission([LOAN_UPDATE, LOAN_ITEM_UPDATE], FALSE))
      $quota_data = $this->payments_m->getLoanItemsAll($loan_id);
    elseif ($this->permission->getPermissionX([AUTHOR_LOAN_UPDATE, AUTHOR_LOAN_ITEM_UPDATE], FALSE))
      $quota_data = $this->payments_m->get_loan_items($this->user_id, $loan_id);
    $search_data = ['quotas' => $quota_data];
    echo json_encode($search_data); // datos leidos por javascript Ajax
  }

  function ajax_get_guarantors($loan_id)
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
  function save_payment()
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
      $quota_id = $this->input->post('quota_id');
      // cargar pagos
      $payments = [];
      if (isset($quota_id)) : if (sizeof($quota_id) > 0) :
          foreach ($quota_id as $id) {
            array_push($payments, ['loan_item_id' => $id, 'mount' => $this->input->post("amount_quota_$id")]);
          }
        endif;
      endif;
      if ($LOAN_UPDATE && $LOAN_ITEM_UPDATE) {
        $this->updateState($loan_id, $quota_id, $payments, $customer_id, $data);
      } elseif ($AUTHOR_LOAN_UPDATE && $AUTHOR_LOAN_ITEM_UPDATE) {
        $probable_user_id = $this->payments_m->get_loan_adviser_user_id($loan_id)->id;
        if (AuthUserData::isAuthor($probable_user_id)) {
          $this->updateState($loan_id, $quota_id, $payments, $customer_id, $data);
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

  private function updateState($loan_id, $quota_id, $payments, $customer_id, $data)
  {
    $validate = $this->payments_m->paymentsOk($payments);
    $savePaymentsIsSuccess = FALSE;
    if ($validate->valid) {
      $savePaymentsIsSuccess = $this->payments_m->addPayments($payments); //descomentar
    } else {
      foreach ($validate->errors as $error)
        echo "ERROR: " . $error;
        return;
    }
    if ($savePaymentsIsSuccess) {
      if (isset($quota_id)) {
        foreach ($quota_id as $q) { // Cambiar estado solo si ya se completó el pago
          if($this->payments_m->paymentsIsEqualToQuote($q))
            $this->payments_m->update_quota(['status' => 0], $q); // descomentar
        }
        if (!$this->payments_m->check_cstLoan($loan_id)) {
          $this->payments_m->update_cstLoan($loan_id, $customer_id); // descomentar
        }
        $data['quotasPaid'] = $this->payments_m->get_quotasPaid($quota_id);
        $data['customerAdvisorName'] = $this->payments_m->getCustomerAdvisorName($customer_id)->user_name;
        $data['payment_user_name'] = $this->session->userdata('academic_degree') .
          " " . $this->session->userdata('first_name') .
          " " . $this->session->userdata('last_name');
        $this->load->view('admin/payments/ticket', $data);
      } else {

        // echo loadErrorMessage('No existen cuotas para registrar');
      }
    } else {
      echo loadErrorMessage('¡Ocurrió un error durante la transacción!');
    }

    // if (isset($quota_id) && FALSE) {
    //   foreach ($quota_id as $q) {
    //     $this->payments_m->update_quota(['status' => 0], $q);
    //   }
    //   if (!$this->payments_m->check_cstLoan($loan_id)) {
    //     $this->payments_m->update_cstLoan($loan_id, $customer_id);
    //   }

    //   $data['quotasPaid'] = $this->payments_m->get_quotasPaid($quota_id);
    //   $data['customerAdvisorName'] = $this->payments_m->getCustomerAdvisorName($customer_id)->user_name;
    //   $data['payment_user_name'] = $this->session->userdata('academic_degree') .
    //     " " . $this->session->userdata('first_name') .
    //     " " . $this->session->userdata('last_name');
    //   $this->load->view('admin/payments/ticket', $data);
    // } else {

    //   // echo loadErrorMessage('No existen cuotas para registrar');
    // }
  }


  /**
   * ticket Considerar modificar, ya no guarda nada, solo muestra documento de pago
   */
//   function ticket()
//   {
//     $LOAN_UPDATE = $this->permission->getPermission([LOAN_UPDATE], FALSE);
//     $LOAN_ITEM_UPDATE = $this->permission->getPermission([LOAN_ITEM_UPDATE], FALSE);
//     $AUTHOR_LOAN_UPDATE = $this->permission->getPermission([AUTHOR_LOAN_UPDATE], FALSE);
//     $AUTHOR_LOAN_ITEM_UPDATE = $this->permission->getPermission([AUTHOR_LOAN_ITEM_UPDATE], FALSE);
//     // echo "El valor del atributo (amount_quota_14) es: " . $this->input->post('amount_quota_14');
//     // echo "<br>";
//     // echo "El valor del atributo (amount_quota_15 disabled) es: " . $this->input->post('amount_quota_15');
//     if ($this->input->post('customer_id') != null) { // valida que no se acceda desde la url sin datos de entrada
//       if ($LOAN_UPDATE && $LOAN_ITEM_UPDATE)
//         $data['customerName'] = $this->payments_m->getCustomerByIdAll($this->input->post('customer_id'));
//       elseif ($AUTHOR_LOAN_UPDATE && $AUTHOR_LOAN_ITEM_UPDATE)
//         $data['customerName'] = $this->payments_m->get_customer_by_id($this->user_id, $this->input->post('customer_id'));
//       $data['coin'] = $this->input->post('coin');
//       $data['loan_id'] = $this->input->post('loan_id');

//       if ($LOAN_UPDATE && $LOAN_ITEM_UPDATE) {
//         $this->updateState($this->input->post('loan_id'), $this->input->post('quota_id'), $this->input->post('customer_id'), $data);
//       } elseif ($AUTHOR_LOAN_UPDATE && $AUTHOR_LOAN_ITEM_UPDATE) {
//         $probable_user_id = $this->payments_m->get_loan_adviser_user_id($this->input->post('loan_id'))->id;
//         if (AuthUserData::isAuthor($probable_user_id)) {
//           $this->updateState($this->input->post('loan_id'), $this->input->post('quota_id'), $this->input->post('customer_id'), $data);
//         } else {
//           echo PERMISSION_DENIED_MESSAGE;
//         }
//       } else {
//         echo PERMISSION_DENIED_MESSAGE;
//       }
//     } else {
//       echo loadErrorMessage('¡Imposible acceder a está página, faltan datos de entrada de la transacción!');
//     }
//   }
}

/* End of file Payments.php */
/* Location: ./application/controllers/admin/Payments.php */