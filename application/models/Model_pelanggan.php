<?php 

class Model_pelanggan extends CI_Model
{

    public function select($table, $limit = null, $start = null)
    {
        return $this->db->get($table, $limit, $start)->result();
    }

    public function insert($table, $data)
    {
        $this->db->insert($table, $data);
    }

    public function update($table, $data, $id)
    {
        $this->db->where($id);
        $this->db->update($table, $data);
    }

    public function get($table, $id)
    {
        return $this->db->get_where($table, $id)->result();
    }

    public function get_one($table, $id, $idwhere)
    {
        $result = $this->db->where($idwhere, $id)
            ->get($table);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return array();
        }
    }

    public function get_one_ordered($table, $id, $idwhere, $col, $cending)
    {
        $result = $this->db->where($idwhere, $id)->order_by($col, $cending)
            ->get($table);
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return array();
        }
    }

    public function get_where_ordered($table, $where, $val, $col, $cending, $limit = null, $start = null)
    {
        $this->db->from($table);
        $this->db->where($where, $val);
        $this->db->order_by($col, $cending);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_keyword($table, $where, $val, $col, $keyword, $order, $cending, $limit = null, $start = null)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where, $val);
        $this->db->like($col, $keyword);
        $this->db->order_by($order, $cending);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

}
