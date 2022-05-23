<?php

	class Dashboard extends CI_Controller {
		
		public function __construct(){
			parent::__construct();
			$this->load->model('model_admin');
		}

		public function index(){				
			$id = $this->session->id_resto;
			$data['menu'] = $this->model_admin->count_one('menu', 'id_resto', $id);
			$data['pegawai'] = $this->model_admin->count_one('pegawai', 'id_resto', $id);
			$data['meja'] = $this->model_admin->count_one('meja', 'id_resto', $id);
			$data['order'] = $this->model_admin->count_one('penjualan', 'id_resto', $id);
			$data['transaksi'] = $this->model_admin->count_two('penjualan', 'id_resto', $id, 'tanggal', date('Y-m-d'));
			
			$this->load->view('pemilik/template/header_pemilik');
			$this->load->view('pemilik/dashboard', $data);
			$this->load->view('pemilik/template/footer_pemilik');
		}

		public function logout(){
			$this->session->unset_userdata(
				array(
					'id_pemilik',
					'username',
					'level'
				)
			);
			redirect('login');
		}

	}

?>
