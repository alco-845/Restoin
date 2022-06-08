<?php

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_admin');
    }

    public function index()
    {
        $id = $this->session->id_resto;
        $config['base_url'] = site_url('pegawai/transaksi/index');
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
        if ($search) {
            $data['transaksi'] = $this->model_admin->get_keyword('laporan_penjualan', 'id_resto', $id, 'pelanggan', $search, 'id_penjualan', 'asc');
            $data['pagination'] = "";
        } else {
            $data['transaksi'] = $this->model_admin->get_where_ordered('laporan_penjualan', 'id_resto', $id, 'id_penjualan', 'asc', $config["per_page"], $data['page']);
            $data['pagination'] = $this->pagination->create_links();
        }

        $this->load->view('pegawai/template/header_pegawai');
        $this->load->view('pegawai/transaksi/transaksi_select', $data);
        $this->load->view('pegawai/template/footer_pegawai');
    }

    public function detail($id)
    {
        $where = array('id_penjualan' => $id);
        $data['transaksi'] = $this->model_admin->get('laporan_penjualan', $where);

        $data['item'] = $this->model_admin->get('item_penjualan', $where);

        $this->load->view('pegawai/template/header_pegawai');
        $this->load->view('pegawai/transaksi/transaksi_detail', $data);
        $this->load->view('pegawai/template/footer_pegawai');
    }

    public function bayar()
    {
        $id = $this->input->post('id_penjualan');
        $metode = $this->input->post('metode');
        $total = $this->input->post('total');
        $bayar = $this->input->post('bayar');
        $kembali = $bayar - $total;

        if ($bayar < $total) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                        <p class="text-light">Uang pembayaran kurang</p>
                        <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>'
            );
        redirect('pegawai/transaksi/detail/' . $id);
        } else {
            $hasil = array(
                'total' => $total,
                'bayar' => $bayar,
                'kembali' => $kembali,
                'metode_pembayaran' => $metode,
                'status' => 'Sudah dibayar'
            );
    
            $id_penjualan = array(
                'id_penjualan' => $id
            );
            $this->model_admin->update('penjualan', $hasil, $id_penjualan);
            redirect('pegawai/transaksi/detail/' . $id);
        }
    }

    public function ubah_order($id)
    {
        $get_detail = $this->model_admin->get_one('detail_penjualan', $id, 'id_detail');

        $data = array(
            'status' => 'Selesai'
        );

        $id_detail = array(
            'id_detail' => $id
        );

        $this->model_admin->update('detail_penjualan', $data, $id_detail);;
        redirect('pegawai/transaksi/detail/' . $get_detail->id_penjualan );
    }

    public function ubah_status($id)
    {
        $get_penjualan = $this->model_admin->get_one('penjualan', $id, 'id_penjualan');

        $data_penjualan = array(
            'status' => 'Selesai'
        );

        $id_penjualan = array(
            'id_penjualan' => $id
        );

        $data_meja = array(
            'status' => 'Tersedia'
        );

        $id_meja = array(
            'id_meja' => $get_penjualan->id_meja
        );

        $this->model_admin->update('penjualan', $data_penjualan, $id_penjualan);
        $this->model_admin->update('meja', $data_meja, $id_meja);
        redirect('pegawai/transaksi/detail/' . $id );
    }
}
