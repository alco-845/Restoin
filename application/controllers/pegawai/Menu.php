<?php

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_admin');
    }

    public function index()
    {
        $id = $this->session->id_resto;
        $config['base_url'] = site_url('pegawai/menu/index');
        $config['total_rows'] = $this->model_admin->count_one('menu', 'id_resto', $id);
        $config['per_page'] = 3;
        $config["uri_segment"] = 4;

        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<br><div class="pagging text-center"><nav><ul class="pagination justify-content-left">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span></li>';

        $this->pagination->initialize($config);
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $search = $this->input->post('search');
        if ($search) {
            $data['menu'] = $this->model_admin->get_keyword('menu', 'id_resto', $id, 'menu', $search, 'menu', 'asc');
            $data['opsi'] = "Semua";
            $data['pagination'] = "";
        } else {
            if ($this->input->post('opsi') == 'Makanan' || $this->input->post('opsi') == 'Minuman' || $this->input->post('opsi') == 'Snack') {
                $data['opsi'] = $this->input->post('opsi');
    
                $data['menu'] = $this->model_admin->get_keyword('menu', 'id_resto', $id, 'kategori', $data['opsi'], 'menu', 'asc');
                $data['pagination'] = "";
            } else {
                $data['opsi'] = "Semua";
    
                $data['menu'] = $this->model_admin->get_where_ordered('menu', 'id_resto', $id, 'menu', 'asc', $config["per_page"], $data['page']);
                $data['pagination'] = $this->pagination->create_links();
            } 
        }

        $this->load->view('pegawai/template/header_pegawai');
        $this->load->view('pegawai/menu/menu_select', $data);
        $this->load->view('pegawai/template/footer_pegawai');
    }  
}
