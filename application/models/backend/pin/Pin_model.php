<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pin_model extends CI_Model
{

    public function create(array $data)
    {
        return $this->db->insert('pin', $data);
    }

    public function read($limit, $offset)
    {
        return $this->db->select('*')
            ->from('pin')
            ->order_by('created', 'desc')
            ->limit($limit, $offset)
            ->get()->result();
    }

    public function single($pin_id = null)
    {
        return $this->db->select('*')
            ->from('pin')
            ->where('pin_id', $pin_id)
            ->get()
            ->row();
    }

    public function update(array $data)
    {
        return $this->db->where('pin_id', $data['pin_id'])
            ->update("pin", $data);
    }

    public function delete($pin_id)
    {
        return $this->db->where('pin_id', $pin_id)->delete();
    }
}
