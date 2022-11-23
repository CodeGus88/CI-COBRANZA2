<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends MY_Model {

  protected $_table_name = 'users';

  public $rules = array(
    'email' => array(
      'field' => 'email',
      'label' => 'Email',
      'rules' => 'trim|required|valid_email|max_length[150]'
    ),
    'password' => array(
      'field' => 'password',
      'label' => 'Contraseña',
      'rules' => 'trim|required|max_length[100]'
    )
  );

  public $newUserRules = array(
    'first_name' => array(
      'field' => 'first_name',
      'label' => 'Nombre',
      'rules' => 'trim|required|max_length[50]'
    ),
    'last_name' => array(
      'field' => 'last_name',
      'label' => 'Apellidos',
      'rules' => 'trim|required|max_length[100]'
    ),
    'academic_degree' => array(
      'field' => 'academic_degree',
      'label' => 'Grado académico',
      'rules' => 'trim|max_length[10]'
    ),
    'email' => array(
      'field' => 'email',
      'label' => 'Email',
      'rules' => 'trim|required|valid_email|max_length[150]'
    ),
    'password' => array(
      'field' => 'password',
      'label' => 'Contraseña',
      'rules' => 'trim|required|max_length[100]'
    )
  );

  public function emptyModel($input){
    $user = new stdClass();
    $user->id = $input->post('id')??'';
    $user->first_name = $input->post('first_name')??'';
    $user->last_name = $input->post('last_name')??'';
    $user->email = $input->post('email')??'';
    $user->password = $input->post('password')??'';
    $user->avatar = $input->post('avatar')??'';
    $user->academic_degree = $input->post('academic_degree')??'';
    return $user;
  }

  public function getDegrees(){
    $data = [
      ['ING.', 'ING. | Ingeniero (a)'],
      ['DR.', 'DR. | Doctor'],
      ['DRA.', 'DRA. | Doctora'],
      ['MTR.', 'MTR. | Magister'],
      ['LIC.', 'LIC. | Licenciado (a)'],
      ['SR.', 'SR. | Señor'],
      ['SRA.', 'SRA. | Señora'],
    ];

    return $data;
  }

  public function login()
  {
    $user = $this->get_by([
      'email' => $this->input->post('email'),
      'password' => $this->hash($this->input->post('password'))
    ], TRUE);
    
    if (null !== $user) {
      
      $data = [
        'user_id' => $user->id,
        'academic_degree' => $user->academic_degree,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'avatar' => $user->avatar,
        'loggedin' => TRUE
      ];

      $this->session->set_userdata($data);  

      if($data['loggedin']){
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['full_name'] = $data["first_name"] . " " . $data["last_name"];
      }
      return TRUE;
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
  }

  public function loggedin()
  {
    return (bool) $this->session->userdata('loggedin');
  }

  public function findAll($start, $length, $search, $order)
  {
    // $this->db->select("COUNT(u.id) total");
    $this->db->select("GROUP_CONCAT(r.name)");
    $this->db->from("users u");
    $this->db->join("users_roles ur", "ur.user_id = u.id", "left");
    $this->db->join("roles r", "r.id = ur.role_id", "left");
    $this->db->where("(u.id LIKE '%$search%' OR u.academic_degree LIKE '%$search%' OR u.first_name LIKE '%$search%' OR u.last_name LIKE '%$search%' 
    OR  CONCAT_WS(' ', u.first_name, u.last_name) LIKE '%$search%' OR r.name LIKE '%$search%'
    OR u.email LIKE '%$search%')");
    $this->db->group_by('u.id');
    // $data['recordsFiltered'] = $this->db->get()->row()->total??0;
    $data['recordsFiltered'] = sizeof($this->db->get()->result()??[]);

    $this->db->select("u.id, u.academic_degree, u.first_name, u.last_name, u.email, GROUP_CONCAT(r.name SEPARATOR ',') roles");
    $this->db->from("users u");
    $this->db->join("users_roles ur", "ur.user_id = u.id", "left");
    $this->db->join("roles r", "r.id = ur.role_id", "left");
    $this->db->where("(u.id LIKE '%$search%' OR u.academic_degree LIKE '%$search%' OR u.first_name LIKE '%$search%' OR u.last_name LIKE '%$search%' 
    OR  CONCAT_WS(' ', u.first_name, u.last_name) LIKE '%$search%' OR r.name LIKE '%$search%'
    OR u.email LIKE '%$search%')");
    $this->db->limit($length, $start);
    if($order['column'] == 'full_name'){
      $this->db->order_by("u.first_name", $order['dir']);
      $this->db->order_by("u.last_name", $order['dir']);
    }else{
      $this->db->order_by($order['column'], $order['dir']);
    }
    $this->db->group_by('u.id');

    $data['data'] = $this->db->get()->result()??[];

    return $data;
  }

  public  function findById($id){
    $this->db->select('u.id, u.first_name, u.last_name, u.academic_degree, u.email, u.avatar');
    $this->db->from('users u');
    $this->db->where('u.id', $id);
    return $this->db->get()->row()??null;
  }

  public  function findUserRolesAndPermissions($id){
    $this->db->select('r.id, r.name');
    $this->db->from('roles r');
    $this->db->join('users_roles ur', 'ur.role_id = r.id');
    $this->db->where('ur.user_id', $id);
    $this->db->order_by('r.name');
    $roles = $this->db->get()->result()??[];
    foreach($roles as $role){
      $this->db->select('p.id, p.name');
      $this->db->from('permissions p');
      $this->db->join('roles_permissions rp', 'rp.permission_id = p.id', 'left');
      $this->db->where('rp.role_id', $role->id);
      $this->db->order_by('p.name');
      $role->permissions = $this->db->get()->result()??[];
    }
    return $roles;
  }

  public function deleteById($id){
    return $this->db->delete('users', array('id'=>$id));
  }

}

/* End of file User_m.php */
/* Location: ./application/models/User_m.php */