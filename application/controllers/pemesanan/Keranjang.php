<?php

class Keranjang extends CI_Controller
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
        $data['check'] = "Keranjang";
        $data['cart'] = $this->cart->contents();
        $data['detail'] = false;

        $this->load->view('pemesanan/template/header_pemesanan');
        $this->load->view('pemesanan/template/sidebar_pemesanan', $data);
        $this->load->view('pemesanan/keranjang', $data);
        $this->load->view('pemesanan/template/footer_pemesanan');
    }

    public function beli_tambah($id)
    {
        $where = $this->cart->get_item($id);
        $menu = $this->model_pelanggan->get_one('menu', $where['id'], 'id_menu');
        $data = array(
            'id' => $menu->id_menu,
            'qty' => +1,
            'price' => $menu->harga,
            'name' => $menu->menu
        );

        $this->cart->insert($data);
        redirect('pemesanan/keranjang');
    }

    public function beli_kurang($id)
    {
        $where = $this->cart->get_item($id);
        $menu = $this->model_pelanggan->get_one('menu', $where['id'], 'id_menu');
        if ($where['qty'] == 1) {
            $this->cart->remove($id);
        } else {
            $data = array(
                'id' => $menu->id_menu,
                'qty' => -1,
                'price' => $menu->harga,
                'name' => $menu->menu
            );
            $this->cart->insert($data);
        }

        redirect('pemesanan/keranjang');
    }

    public function beli_hapus($id)
    {
        $this->cart->remove($id);

        redirect('pemesanan/keranjang');
    }

    public function checkout()
    {
        $id_resto = $this->session->id_resto;
        $id_meja = $this->session->id_meja;
        $total = 0;

        $penjualan = array(
            'id_resto' => $id_resto,
            'id_meja' => $id_meja,
            'pelanggan' => $this->session->nama,
            'tanggal' => date('Y-m-d'),
            'metode_pembayaran' => "Belum bayar",
            'status' => "Baru Order"
        );

        $meja = array(
            'status' => 'Dipakai'
        );

        $id_meja_array = array(
            'id_meja' => $id_meja
        );

        $this->model_pelanggan->insert("penjualan", $penjualan);
        $this->model_pelanggan->update('meja', $meja, $id_meja_array);
        $this->session->set_flashdata('insert', TRUE);

        if ($this->session->flashdata('insert') === TRUE) {
            $get_penjualan = $this->model_pelanggan->get_one_ordered('penjualan', $id_resto, 'id_resto', 'id_penjualan', 'desc');

            $id = $get_penjualan->id_penjualan;
            $temp_faktur = '00000000';
            $faktur = substr_replace($temp_faktur, $id, strlen($temp_faktur) - strlen($id));

            foreach ($this->cart->contents() as $item) {
                $detail_penjualan = array(
                    'id_penjualan' => $get_penjualan->id_penjualan,
                    'id_menu' => $item['id'],
                    'jumlah' => $item['qty'],
                    'subtotal' => $item['subtotal'],
                    'status' => 'Proses'
                );
                $total = $total + $item['subtotal'];
                $this->model_pelanggan->insert("detail_penjualan", $detail_penjualan);
            }

            $penjualan = array(
                'no_faktur' => $faktur,
                'total' => $total
            );

            $id_penjualan_array = array(
                'id_penjualan' => $get_penjualan->id_penjualan
            );

            $this->session->set_userdata(array('transaksi_' . $get_penjualan->id_penjualan => $get_penjualan->id_penjualan));

            $this->model_pelanggan->update('penjualan', $penjualan, $id_penjualan_array);

            $this->cart->destroy();
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Terima kasih sudah pesan</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
            );
            redirect('pesan/' . $id_resto);
        }
    }
}
