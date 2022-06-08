<?php 

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_pelanggan');
    }

    public function index($id)
    {
        $data['id'] = $id;
        $data['resto'] = $this->model_pelanggan->get_one('resto', $id, 'id_resto');
        $data['check'] = "Menu";
        $data['detail'] = false;
        
        $search = $this->input->post('search');
        if ($search) {
            $data['menu'] = $this->model_pelanggan->get_keyword('menu', 'id_resto', $id, 'menu', $search, 'menu', 'asc');
            $data['opsi'] = "Semua";
        } else {
            if ($this->input->post('opsi') == 'Makanan' || $this->input->post('opsi') == 'Minuman' || $this->input->post('opsi') == 'Snack') {
                $data['opsi'] = $this->input->post('opsi');
    
                $data['menu'] = $this->model_pelanggan->get_keyword('menu', 'id_resto', $id, 'kategori', $data['opsi'], 'menu', 'asc');
            } else {
                $data['opsi'] = "Semua";
    
                $data['menu'] = $this->model_pelanggan->get_where_ordered('menu', 'id_resto', $id, 'menu', 'asc');
            } 
        }

        $this->load->view('pemesanan/template/header_pemesanan');
        $this->load->view('pemesanan/template/sidebar_pemesanan', $data);
        $this->load->view('pemesanan/menu', $data);
        $this->load->view('pemesanan/template/footer_pemesanan');
    }

    public function beli($id){
        $menu = $this->model_pelanggan->get_one('menu', $id, 'id_menu');
        $data = array(
            'id' => $menu->id_menu,
            'qty' => 1,
            'price' => $menu->harga,
            'name' => $menu->menu
        );

            $this->cart->insert($data);            
            redirect('pemesanan/keranjang');
    }
    
}
