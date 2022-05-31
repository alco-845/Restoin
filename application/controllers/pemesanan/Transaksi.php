<?php

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_pelanggan');
    }

    public function index()
    {
        $data['id'] = $this->session->id_resto;
        $data['resto'] = $this->model_pelanggan->get_one('resto', $data['id'], 'id_resto');
        $data['check'] = "Transaksi";
        $data['transaksi'] = $this->model_pelanggan->get_where_ordered('laporan_penjualan', 'id_resto', $data['id'], 'id_penjualan', 'asc');
        $data['detail'] = false;

        $this->load->view('pemesanan/template/header_pemesanan');
        $this->load->view('pemesanan/template/sidebar_pemesanan', $data);
        $this->load->view('pemesanan/transaksi/transaksi_select', $data);
        $this->load->view('pemesanan/template/footer_pemesanan');
    }

    public function detail($id)
    {
        $data['id'] = $this->session->id_resto;
        $data['resto'] = $this->model_pelanggan->get_one('resto', $data['id'], 'id_resto');
        $data['check'] = "Transaksi";
        $data['detail'] = true;
        
        $where = array('id_penjualan' => $id);
        $data['transaksi'] = $this->model_pelanggan->get('laporan_penjualan', $where);

        $data['item'] = $this->model_pelanggan->get('item_penjualan', $where);

        $this->load->view('pemesanan/template/header_pemesanan');
        $this->load->view('pemesanan/template/sidebar_pemesanan', $data);
        $this->load->view('pemesanan/transaksi/transaksi_detail', $data);
        $this->load->view('pemesanan/template/footer_pemesanan');
    }
}

?>