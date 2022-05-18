<?php

	class Dashboard extends CI_Controller {
		
		public function __construct(){
			parent::__construct();
			$this->load->model('model_admin');
		}

		public function index(){				
			$data['admin'] = $this->model_admin->count_one('admin', 'level', 'Admin');
			$data['resto'] = $this->model_admin->count_one('pemilik', 'level', 'Master');
			
			$this->load->view('super_admin/template/header_admin');
			$this->load->view('super_admin/dashboard', $data);
			$this->load->view('super_admin/template/footer_admin');
		}

		public function logout(){
			$this->session->unset_userdata(
				array(
					'id_admin',
					'username',
					'email',
					'level'
				)
			);
			redirect('login');
		}

	}

?>
