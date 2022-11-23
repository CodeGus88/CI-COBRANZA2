<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role_m extends MY_Model{

    private $rules = [];
    protected $_table_name = 'roles';

    public function getRules(){
        return $this->rules;
    }

    /**
     * Muestra todos los roles con paginación
     */
    public function findAll($start, $length, $search, $order)
    {
        $this->db->select('COUNT(id) total');
        $this->db->from('roles');
        $this->db->where("id LIKE '%$search%' OR name LIKE '%$search%'");
        $data['recordsFiltered'] = $this->db->get()->row()->total??0;

        $this->db->select('*');
        $this->db->from('roles');
        $this->db->where("id LIKE '%$search%' OR name LIKE '%$search%'");
        $this->db->limit($length, $start);
        $this->db->order_by($order['column'], $order['dir']);
        $data['data'] = $this->db->get()->result()??[];

        return $data;
    }

}