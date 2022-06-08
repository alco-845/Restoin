<?php

class Laporan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_admin');
    }

    public function index()
    {
        $id = $this->session->id_resto;
        $config['base_url'] = site_url('pemilik/laporan/index');
        $config['total_rows'] = $this->model_admin->count_one('laporan_penjualan', 'id_resto', $id);
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
        $tawal = $this->input->post('tawal');
        $takhir = $this->input->post('takhir');
        if ($this->input->post('filter')) {
            if ($tawal == '' || $takhir == '') {
                $tawal = date('Y-m-d');
                $takhir = date('Y-m-d');
            }
            $data['laporan'] = $this->model_admin->get_date_keyword('laporan_penjualan', 'id_resto', $id, 'pelanggan', $search, $tawal, $takhir, 'id_penjualan', 'asc');
            $data['pagination'] = "";
        } else {
            $data['laporan'] = $this->model_admin->get_where_ordered('laporan_penjualan', 'id_resto', $id, 'id_penjualan', 'asc', $config["per_page"], $data['page']);
            $data['pagination'] = $this->pagination->create_links();
        }

        $this->load->view('pemilik/template/header_pemilik');
        $this->load->view('pemilik/laporan/laporan_select', $data);
        $this->load->view('pemilik/template/footer_pemilik');
    }

    public function detail($id)
    {
        $where = array('id_penjualan' => $id);
        $data['laporan'] = $this->model_admin->get('laporan_penjualan', $where);

        $data['item'] = $this->model_admin->get('item_penjualan', $where);

        $this->load->view('pemilik/template/header_pemilik');
        $this->load->view('pemilik/laporan/laporan_detail', $data);
        $this->load->view('pemilik/template/footer_pemilik');
    }
}
