<?php
include(APPPATH."/tools/AuthUserData.php");

const AUTHOR_CRUD =  'AUTHOR_CRUD';
const PERMISSION_CREATE = 'PERMISSION_CREATE';
const PERMISSION_READ = 'PERMISSION_READ';
const PERMISSION_UPDATE = 'PERMISSION_UPDATE';
const PERMISSION_DELETE = 'PERMISSION_DELETE';
const ROLE_PERMISION_CREATE = 'ROLE_PERMISION_CREATE';
const ROLE_PERMISION_READ = 'ROLE_PERMISION_READ';
const ROLE_PERMISION_UPDATE = 'ROLE_PERMISION_UPDATE';
const ROLE_PERMISION_DELETE = 'ROLE_PERMISION_DELETE';
const ROLE_CREATE = 'ROLE_CREATE';
const ROLE_READ = 'ROLE_READ';
const ROLE_UPDATE = 'ROLE_UPDATE';
const ROLE_DELETE = 'ROLE_DELETE';
const USER_ROLE_CREATE = 'USER_ROLE_CREATE';
const USER_ROLE_READ = 'USER_ROLE_READ';
const USER_ROLE_UPDATE = 'USER_ROLE_UPDATE';
const USER_ROLE_DELETE = 'USER_ROLE_DELETE';
const USER_CREATE = 'USER_CREATE';
const USER_READ = 'USER_READ';
const USER_UPDATE = 'USER_UPDATE';
const USER_DELETE = 'USER_DELETE';
const CUSTOMER_CREATE = 'CUSTOMER_CREATE';
const CUSTOMER_READ = 'CUSTOMER_READ';
const CUSTOMER_UPDATE = 'CUSTOMER_UPDATE';
const CUSTOMER_DELETE = 'CUSTOMER_DELETE';
const LOAN_CREATE = 'LOAN_CREATE';
const LOAN_READ = 'LOAN_READ';
const LOAN_UPDATE = 'LOAN_UPDATE';
const LOAN_DELETE = 'LOAN_DELETE';
const LOAN_ITEM_CREATE = 'LOAN_ITEM_CREATE';
const LOAN_ITEM_READ = 'LOAN_ITEM_READ';
const LOAN_ITEM_UPDATE = 'LOAN_ITEM_UPDATE';
const LOAN_ITEM_DELETE = 'LOAN_ITEM_DELETE';
const GUARANTOR_CREATE = 'GUARANTOR_CREATE';
const GUARANTOR_READ = 'GUARANTOR_READ';
const GUARANTOR_UPDATE = 'GUARANTOR_UPDATE';
const GUARANTOR_DELETE = 'GUARANTOR_DELETE';
const MICROPAIMENT_CREATE = 'MICROPAIMENT_CREATE';
const MICROPAIMENT_READ = 'MICROPAIMENT_READ';
const MICROPAIMENT_UPDATE = 'MICROPAIMENT_UPDATE';
const MICROPAIMENT_DELETE = 'MICROPAIMENT_DELETE';
const COIN_CREATE = 'COIN_CREATE';
const COIN_READ = 'COIN_READ';
const COIN_UPDATE = 'COIN_UPDATE';
const COIN_DELETE = 'COIN_DELETE';
const PERMISSION_DENIED_MESSAGE =  "<script> 
// Swal.fire({icon: 'error', title: 'Oops...', text: '¡Permiso denegado!', footer: '<a ></a>' });  
alert('Permiso denegado...');
window.history.back();
</script>";//"<script>alert('Permiso denegado...'); window.history.back();</script>";

class Permission {

    private $model;
    private $user_id;
    
    public function __construct($model, $user_id){
        $this->model = $model;
        $this->user_id = $user_id;
    }

    public function getPermission($permissions, $redirect){
        $permit = FALSE;
        foreach($permissions as $permission){
            $permit = $permit || $this->model->getAuthorization($this->user_id, $permission);
        }
        if($redirect){
            if(!$permit){
                redirect('/admin/dashboard','refresh');
            }else{
                return $permit;
            }
        }else{
            return $permit;
        }
    }

    public function getPermissionX($permissions, $redirect){
        $permit = TRUE;
        foreach($permissions as $permission){
            $permit = $permit && $this->model->getAuthorization($this->user_id, $permission);
        }
        if($redirect){
            if(!$permit){
                redirect('/admin/dashboard','refresh');
            }else{
                return $permit;
            }
        }else{
            return $permit;
        }
    }
}

?>