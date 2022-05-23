<?php

class Model_admin extends CI_Model
{

    public function count_table($table)
    {
        return $this->db->count_all($table);
    }

    public function count_one($table, $col, $val)
    {
        return $this->db->where($col, $val)->count_all_results($table);
    }

    public function count_two($table, $col1, $val1, $col2, $val2)
    {
        return $this->db->where($col1, $val1)->where($col2, $val2)->count_all_results($table);
    }

    public function select($table, $limit = null, $start = null)
    {
        return $this->db->get($table, $limit, $start)->result();
    }

    public function insert($table, $data)
    {
        $this->db->insert($table, $data);
    }

    public function delete($table, $id)
    {
        $this->db->where($id);
        $this->db->delete($table);
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

    public function get_one_ordered($table, $where, $cending)
    {
        $result = $this->db->order_by($where, $cending)
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

    public function get_ordered($table, $where, $cending, $start = null, $end = null)
    {
        $this->db->from($table);
        $this->db->order_by($where, $cending);
        $this->db->limit($start, $end);
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

    public function get_date_keyword($table, $where, $val, $col, $keyword, $first, $second, $order, $cending, $limit = null, $start = null)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where, $val);
        $this->db->like($col, $keyword);
        $this->db->where('tanggal >=', $first);
        $this->db->where('tanggal <=', $second);
        $this->db->order_by($order, $cending);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    function check_value($table, $column, $val)
    {
        $this->db->where($column, $val);
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
