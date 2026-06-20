<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends CI_Model
{
    private $table = 'tasks';

    public function get_all($only_pending = false)
    {
        if ($only_pending) {
            $this->db->where('is_done', 0);
        }
        $this->db->order_by('due_date', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function get($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    public function get_due_soon($hours = 24)
    {
        $now = date('Y-m-d H:i:s');
        $until = date('Y-m-d H:i:s', strtotime("+{$hours} hours"));

        $this->db->where('is_done', 0);
        $this->db->where('due_date >=', $now);
        $this->db->where('due_date <=', $until);
        $this->db->order_by('due_date', 'ASC');

        return $this->db->get($this->table)->result();
    }

    public function create($data)
    {
        $now = date('Y-m-d H:i:s');
        $data['created_at'] = $now;
        $data['updated_at'] = $now;
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function mark_done($id, $is_done = 1)
    {
        return $this->update($id, array('is_done' => $is_done));
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array('id' => $id));
    }
}
