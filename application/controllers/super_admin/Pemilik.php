<?php

class Pemilik extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_admin');
    }

    public function index()
    {
        $config['base_url'] = site_url('super_admin/pemilik/index');
        $config['total_rows'] = $this->model_admin->count_table('pemilik');
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
            $data['pemilik'] = $this->model_admin->get_keyword('pemilik', 'level', 'Admin', 'username', $search, 'username', 'asc');
            $data['pagination'] = "";
        } else {
            $data['pemilik'] = $this->model_admin->get_where_ordered('pemilik', 'level', 'Admin', 'username', 'asc', $config["per_page"], $data['page']);
            $data['pagination'] = $this->pagination->create_links();
        }

        $this->load->view('super_admin/template/header_admin');
        $this->load->view('super_admin/pemilik/pemilik_select', $data);
        $this->load->view('super_admin/template/footer_admin');
    }

    public function tambah()
    {
        $data['input_data'] = array(
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        );

        $this->load->view('super_admin/template/header_admin');
        $this->load->view('super_admin/pemilik/pemilik_insert', $data);
        $this->load->view('super_admin/template/footer_admin');
    }

    public function tambah_proses()
    {
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $pass = $this->input->post('pass');
        $conf_pass = $this->input->post('conf_pass');
        $nama_pemilik = $this->input->post('nama_pemilik');
        $nama = $this->input->post('nama');
        $logo_file = $_FILES['logo_file'];
        $alamat = $this->input->post('alamat');

        $data['input_data'] = array(
            $username,
            $email,
            $pass,
            $conf_pass,
            $nama,
            $nama_pemilik,
            $alamat,
        );

        if ($pass == $conf_pass) {
            $get_data = $this->model_admin->get_one('admin', $username, 'username');

            if ($get_data == FALSE) {
                $hasil_resto = array(
                    'nama_pemilik' => $nama_pemilik,
                    'nama' => $nama,
                    'alamat' => $alamat
                );

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil menambah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                $this->model_admin->insert("resto", $hasil_resto);
                $this->session->set_flashdata('insert', TRUE);
                if ($this->session->flashdata('insert') === TRUE) {
                    $get_resto = $this->model_admin->get_one_ordered('resto', 'id_resto', 'desc');
                    $id_resto = $get_resto->id_resto;

                    $this->load->library('ciqrcode');
                    $qr_name = 'resto_' . $id_resto . '.png';
                    $params['data'] = base_url() . 'pesan/' . $id_resto;
                    $params['level'] = 'H';
                    $params['size'] = 10;
                    $params['savename'] = FCPATH . './assets/img/upload/qrcode/' . $qr_name;
                    $this->ciqrcode->generate($params);

                    $tmp = $_FILES['logo_file']['tmp_name'];
                if (!empty($tmp)) {
                    $logo_file = $id_resto . '_' . date('Y-m-d') . '_' . $_FILES['logo_file']['name'];
                    move_uploaded_file($tmp, './assets/img/upload/restoran/' . $logo_file);                    
                } else {
                    $logo_file = "default.jpg";
                }

                    $hasil_admin = array(
                        'id_resto' => $id_resto,
                        'username' => $username,
                        'email' => $email,
                        'password' => $pass,
                        'level' => 'Admin',
                        'aktif' => 1
                    );

                    $hasil_resto = array(
                        'logo' => $logo_file,
                        'qrcode' => $qr_name
                    );

                    $id_resto_array = array(
                        'id_resto' => $id_resto
                    );

                    $this->model_admin->insert("admin", $hasil_admin);
                    $this->model_admin->update('resto', $hasil_resto, $id_resto_array);
                    redirect('super_admin/pemilik');
                }
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Username sudah ada</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                $this->load->view('super_admin/template/header_admin');
                $this->load->view('super_admin/pemilik/pemilik_insert', $data);
                $this->load->view('super_admin/template/footer_admin');
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
				<p class="text-light">Password tidak sama</p>
				<button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
			  </div>'
            );

            $this->load->view('super_admin/template/header_admin');
            $this->load->view('super_admin/pemilik/pemilik_insert', $data);
            $this->load->view('super_admin/template/footer_admin');
        }
    }

    public function hapus($id)
    {
        $penjualan = $this->model_admin->count_one('penjualan', 'id_resto', $id);
        $meja = $this->model_admin->count_one('meja', 'id_resto', $id);
        $menu = $this->model_admin->count_one('menu', 'id_resto', $id);
        $pegawai = $this->model_admin->count_one('pegawai', 'id_resto', $id);
        
        $get = $this->model_admin->get_one('pemilik', $id, 'id_resto');
        unlink('./assets/img/upload/qrcode/' . $get->qrcode);
        if ($get->logo != "default.jpg") {
            unlink('./assets/img/upload/restoran/' . $get->logo);
        }

        $where = array('id_resto' => $id);        

        if ($penjualan > 0 || $meja > 0 || $menu > 0 || $pegawai > 0) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 80px;">
                <p class="text-light">Tidak bisa dihapus, akun ini memiliki data</p>
                <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>'
            );
        } else {
            $this->model_admin->delete('admin', $where);
            $this->model_admin->delete('resto', $where);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                <p class="text-light">Berhasil menghapus data</p>
                <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>'
            );
        }                
        redirect('super_admin/pemilik');
    }

    public function ubah($id)
    {
        $where = array('id_admin' => $id);
        $data['pemilik'] = $this->model_admin->get('pemilik', $where);

        $this->load->view('super_admin/template/header_admin');
        $this->load->view('super_admin/pemilik/pemilik_update', $data);
        $this->load->view('super_admin/template/footer_admin');
    }

    public function ubah_proses()
    {
        $id_admin = $this->input->post('id_admin');
        $id_resto = $this->input->post('id_resto');
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $pass = $this->input->post('pass');
        $conf_pass = $this->input->post('conf_pass');
        $nama_pemilik = $this->input->post('nama_pemilik');
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');

        $logo_file = $_FILES['logo_file'];

        if ($pass == $conf_pass) {
            $cekData = $this->model_admin->check_value('admin', 'username', $username);
            $getData = $this->model_admin->get_one('admin', $id_admin, 'id_admin');

            if ($cekData == TRUE && $getData->username == $username) {
                $hasil_admin = array(
                    'id_resto' => $id_resto,
                    'username' => $username,
                    'email' => $email,
                    'password' => $pass,
                    'level' => 'Admin'
                );

                $id_admin_array = array(
                    'id_admin' => $id_admin
                );

                $get = $this->model_admin->get_one('pemilik', $id_resto, 'id_resto');
                $tmp = $_FILES['logo_file']['tmp_name'];
                if (!empty($tmp)) {
                    $logo_file = $get->id_resto . '_' . date('Y-m-d') . '_' . $_FILES['logo_file']['name'];
                    move_uploaded_file($tmp, './assets/img/upload/restoran/' . $logo_file);
                    if ($get->logo != "default.jpg") {
                        unlink('./assets/img/upload/restoran/' . $get->logo);
                    }
                } else {
                    $logo_file = $get->logo;
                }

                $hasil_resto = array(
                    'nama_pemilik' => $nama_pemilik,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'logo' => $logo_file
                );

                $id_resto_array = array(
                    'id_resto' => $id_resto
                );

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil mengubah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                $this->model_admin->update('admin', $hasil_admin, $id_admin_array);
                $this->model_admin->update('resto', $hasil_resto, $id_resto_array);
                redirect('super_admin/pemilik');
            } else if ($cekData == FALSE) {
                $hasil_admin = array(
                    'id_resto' => $id_resto,
                    'username' => $username,
                    'email' => $email,
                    'password' => $pass,
                    'level' => 'Admin'
                );

                $id_admin_array = array(
                    'id_admin' => $id_admin
                );

                $get = $this->model_admin->get_one('pemilik', $id_resto, 'id_resto');
                $tmp = $_FILES['logo_file']['tmp_name'];
                if (!empty($tmp)) {
                    $logo_file = $get->id_resto . '_' . date('Y-m-d') . '_' . $_FILES['logo_file']['name'];
                    move_uploaded_file($tmp, './assets/img/upload/restoran/' . $logo_file);
                    if ($get->logo != "default.jpg") {
                        unlink('./assets/img/upload/restoran/' . $get->logo);
                    }
                } else {
                    $logo_file = $get->logo;
                }

                $hasil_resto = array(
                    'nama_pemilik' => $nama_pemilik,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'logo' => $logo_file
                );

                $id_resto_array = array(
                    'id_resto' => $id_resto
                );

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil mengubah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                $this->model_admin->update('admin', $hasil_admin, $id_admin_array);
                $this->model_admin->update('resto', $hasil_resto, $id_resto_array);
                redirect('super_admin/pemilik');
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Username sudah ada</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                redirect('super_admin/pemilik/ubah/' . $id_admin);
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
				<p class="text-light">Password tidak sama</p>
				<button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
			  </div>'
            );

            redirect('super_admin/pemilik/ubah/' . $id_admin);
        }
    }

    public function ubah_status($id)
    {
        $stat = $this->model_admin->get_one('admin', $id, 'id_admin');

        if ($stat->aktif == 0) {
            $aktif = 1;
        } else {
            $aktif = 0;
        }

        $data = array(
            'aktif' => $aktif
        );

        $id = array(
            'id_admin' => $id
        );

        $this->model_admin->update('admin', $data, $id);
        redirect('super_admin/pemilik');
    }

    public function detail($id)
    {
        $where = array('id_admin' => $id);
        $data['pemilik'] = $this->model_admin->get('pemilik', $where);

        $this->load->view('super_admin/template/header_admin');
        $this->load->view('super_admin/pemilik/pemilik_detail', $data);
        $this->load->view('super_admin/template/footer_admin');
    }
}
