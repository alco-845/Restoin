<?php

	class Dashboard extends CI_Controller {
		
		public function __construct(){
			parent::__construct();
			$this->load->model('model_admin');
		}

		public function index(){				
			$id = $this->session->id_resto;
			$data['menu'] = $this->model_admin->count_one('menu', 'id_resto', $id);			
			$data['transaksi'] = $this->model_admin->count_two('penjualan', 'id_resto', $id, 'tanggal', date('Y-m-d'));
			
			$this->load->view('pegawai/template/header_pegawai');
			$this->load->view('pegawai/dashboard', $data);
			$this->load->view('pegawai/template/footer_pegawai');
		}

		public function logout(){
			$this->session->sess_destroy();
			redirect('login');
		}

	}
