<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Task_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $filter = $this->input->get('filter');
        $data['tasks'] = $this->Task_model->get_all($filter === 'pending');
        $data['filter'] = $filter;
        $data['due_soon'] = $this->Task_model->get_due_soon(24);
        $this->load->view('tasks/index', $data);
    }

    public function create()
    {
        $this->form_validation->set_rules('title', 'Tên công việc', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('due_date', 'Hạn hoàn thành', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['task'] = null;
            $this->load->view('tasks/form', $data);
            return;
        }

        $this->Task_model->create(array(
            'title'       => $this->input->post('title', TRUE),
            'description' => $this->input->post('description', TRUE),
            'due_date'    => $this->_normalize_due_date($this->input->post('due_date', TRUE)),
            'is_done'     => 0,
        ));

        $this->session->set_flashdata('message', 'Đã thêm công việc mới.');
        redirect('tasks');
    }

    public function new_form()
    {
        $data['task'] = null;
        $this->load->view('tasks/form', $data);
    }

    public function edit($id)
    {
        $task = $this->Task_model->get($id);
        if (!$task) {
            show_404();
        }
        $data['task'] = $task;
        $this->load->view('tasks/form', $data);
    }

    public function update($id)
    {
        $task = $this->Task_model->get($id);
        if (!$task) {
            show_404();
        }

        $this->form_validation->set_rules('title', 'Tên công việc', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('due_date', 'Hạn hoàn thành', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['task'] = $task;
            $this->load->view('tasks/form', $data);
            return;
        }

        $this->Task_model->update($id, array(
            'title'       => $this->input->post('title', TRUE),
            'description' => $this->input->post('description', TRUE),
            'due_date'    => $this->_normalize_due_date($this->input->post('due_date', TRUE)),
        ));

        $this->session->set_flashdata('message', 'Đã cập nhật công việc.');
        redirect('tasks');
    }

    public function toggle($id)
    {
        $task = $this->Task_model->get($id);
        if (!$task) {
            show_404();
        }
        $this->Task_model->mark_done($id, $task->is_done ? 0 : 1);
        redirect('tasks');
    }

    public function delete($id)
    {
        $task = $this->Task_model->get($id);
        if (!$task) {
            show_404();
        }
        $this->Task_model->delete($id);
        $this->session->set_flashdata('message', 'Đã xóa công việc.');
        redirect('tasks');
    }

    private function _normalize_due_date($value)
    {
        // datetime-local inputs submit "YYYY-MM-DDTHH:MM"; MySQL needs a space separator
        return str_replace('T', ' ', $value);
    }
}
