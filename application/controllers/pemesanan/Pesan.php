<?php

	class Pesan extends CI_Controller {
		
		public function __construct(){
			parent::__construct();
			$this->load->model('model_pelanggan');
		}

		public function index($id){				
			$data['resto'] = $this->model_pelanggan->get_one('resto', $id, 'id_resto');
			$data['meja'] = $this->model_pelanggan->get_keyword('meja', 'id_resto', $id, 'status', 'Tersedia', 'id_meja', 'asc');
			
			$this->load->view('login/header_login');
			$this->load->view('pemesanan/pesan', $data);
		}

		public function login(){
			$id_resto = $this->input->post('id_resto');
			$resto = $this->model_pelanggan->get_one('resto', $id_resto, 'id_resto');

			$nama = $this->input->post('nama');

			$id_meja = $this->input->post('meja');
			$meja = $this->model_pelanggan->get_one('meja', $id_meja, 'id_meja');

			$this->session->set_userdata(
				array(
					'id_resto' => $id_resto,
					'id_meja' => $id_meja,
					'nama_resto' => $resto->nama,
					'nama' => $nama,
					'meja' => $meja->nomer
				)
			);
			$this->cart->destroy();
			redirect("pemesanan/menu");
		}

		public function logout(){
			$id = $this->session->id_resto;
			$this->session->unset_userdata(
				array(
					'id_resto',
					'nama_resto',
					'nama',
					'meja'
				)
			);
			redirect('pesan/' . $id);
		}

	}
