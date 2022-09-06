<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_m extends CI_Model {

    /** Verifica si el usuario  tiene el permmiso */
    public function getAuthorization($user_id, $permission){
        $this->db->select('p.*');
        $this->db->from('permissions p');
        $this->db->join('roles_permissions rp', "rp.permission_id = p.id");
        $this->db->join('roles r', "r.id = rp.role_id");
        $this->db->join('users_roles ur', "ur.role_id = r.id");
        $this->db->join('users u', "u.id = ur.user_id");
        $this->db->where('p.name', $permission);
        $this->db->where('u.id', $user_id);
        if($this->db->get()->num_rows() > 0){
            return true;
        }else {
            return false;
        } 
    }

    /**Devuelve la lista de permisos del usuario */
    public function getPermissions($user_id){
        $this->db->select('p.name');
        $this->db->from('permissions');
        $this->db->join('roles_permisions rp', "rp.permission_id = p.id");
        $this->db->join('roles r', "r.id = rp.role_id");
        $this->db->join('users_roles ur', "ur.role_id = r.id");
        $this->db->join('user u', "u.id = ur.user_id");
        $this->db->where('u.id', $user_id);
        return $this->db->get()->result();
    }

}