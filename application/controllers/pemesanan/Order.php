<?php

class Order extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_pelanggan');
	}

	public function index($id)
	{
		$data['resto'] = $this->model_pelanggan->get_one('resto', $id, 'id_resto');
		$data['meja'] = $this->model_pelanggan->get_keyword('meja', 'id_resto', $id, 'status', 'Tersedia', 'id_meja', 'asc');

		$this->load->view('login/header_login');
		$this->load->view('pemesanan/order', $data);
	}

	public function login()
	{
		$id_resto = $this->input->post('id_resto');
		$resto = $this->model_pelanggan->get_one('resto', $id_resto, 'id_resto');

		$nama = $this->input->post('nama');

		$id_meja = $this->input->post('meja');
		if ($id_meja == null) {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 80px;">
					<p class="text-light">Meja kosong, mohon konfirmasi ke restoran</p>
					<button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
				  </div>'
			);
			redirect("pesan/" . $id_resto);
		} else {
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
			redirect("pesan/" . $id_resto);
		}
	}

	public function logout()
	{
		$id = $this->session->id_resto;
		$this->cart->destroy();
		$this->session->sess_destroy();
		redirect('order/' . $id);
	}
}
