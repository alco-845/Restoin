<?php

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_admin');
	}

	public function index()
	{
		$this->load->view('login/header_login');
		$this->load->view('login/login_admin');
	}

	public function auth_admin()
	{
		$username = $this->input->post('username');
		$pass = $this->input->post('password');

		$data = array(
			'username' => $username,
			'password' => $pass,
			'aktif' => 1
		);

		$authAdmin = $this->model_admin->get("admin", $data);
		$authPegawai = $this->model_admin->get("pegawai", $data);

		$getAdmin = $this->model_admin->get_one('admin', $username, 'username');
		$getPegawai = $this->model_admin->get_one('pegawai', $username, 'username');

		if ($authAdmin == TRUE || $authPegawai == TRUE) {
			if ($getAdmin->level === "Master") {
				$this->session->set_userdata(
					array(
						'id_admin' => $getAdmin->id_admin,
						'username' => $getAdmin->username,
						'level' => $getAdmin->level
					)
				);
				redirect("super_admin/dashboard");
			} else if ($getAdmin->level === "Admin") {
				$this->session->set_userdata(
					array(
						'id_pemilik' => $getAdmin->id_admin,
						'id_resto' => $getAdmin->id_resto,
						'username' => $getAdmin->username,
						'level' => $getAdmin->level
					)
				);
				redirect("pemilik/dashboard");
			} else if ($getPegawai->username === $username) {
				$this->session->set_userdata(
					array(
						'id_pegawai' => $getPegawai->id_pegawai,
						'id_resto' => $getPegawai->id_resto,
						'username' => $getPegawai->username,
						'nama' => $getPegawai->nama,
						'level' => 'Pegawai'
					)
				);
				redirect("pegawai/dashboard");
			}
		} else if ($getAdmin->aktif == '0' || $getPegawai->aktif == '0') {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
				<p class="text-light">Akun dibanned</p>
				<button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
			  </div>'
			);
			redirect("login");
		} else {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
				<p class="text-light">Username atau password salah</p>
				<button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
			  </div>'
			);
			redirect("login");
		}
	}
}
