<?php

class Pegawai extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_admin');
    }

    public function index()
    {
        $id = $this->session->id_resto;
        $config['base_url'] = site_url('pemilik/pegawai/index');
        $config['total_rows'] = $this->model_admin->count_one('pegawai', 'id_resto', $id);
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
            $data['pegawai'] = $this->model_admin->get_keyword('pegawai', 'id_resto', $id, 'username', $search, 'username', 'asc');
            $data['pagination'] = "";
        } else {
            $data['pegawai'] = $this->model_admin->get_where_ordered('pegawai', 'id_resto', $id, 'username', 'asc', $config["per_page"], $data['page']);
            $data['pagination'] = $this->pagination->create_links();
        }


        $this->load->view('pemilik/template/header_pemilik');
        $this->load->view('pemilik/pegawai/pegawai_select', $data);
        $this->load->view('pemilik/template/footer_pemilik');
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
        );

        $this->load->view('pemilik/template/header_pemilik');
        $this->load->view('pemilik/pegawai/pegawai_insert', $data);
        $this->load->view('pemilik/template/footer_pemilik');
    }

    public function tambah_proses()
    {
        $username = $this->input->post('username');
        $pass = $this->input->post('pass');
        $conf_pass = $this->input->post('conf_pass');
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $notelp = $this->input->post('notelp');

        $data['input_data'] = array(
            $nama,
            $username,
            $pass,
            $conf_pass,
            $alamat,
            $notelp,
        );

        if ($pass == $conf_pass) {
            $getData = $this->model_admin->get_one('pegawai', $username, 'username');

            if ($getData == FALSE) {
                $hasil = array(
                    'id_resto' => $this->session->id_resto,
                    'username' => $username,
                    'password' => $pass,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'notelp' => $notelp,
                    'aktif' => 1
                );

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil menambah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                $this->model_admin->insert("pegawai", $hasil);
                redirect('pemilik/pegawai');
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Username sudah ada</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                $this->load->view('pemilik/template/header_pemilik');
                $this->load->view('pemilik/pegawai/pegawai_insert', $data);
                $this->load->view('pemilik/template/footer_pemilik');
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
				<p class="text-light">Password tidak sama</p>
				<button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
			  </div>'
            );

            $this->load->view('pemilik/template/header_pemilik');
            $this->load->view('pemilik/pegawai/pegawai_insert', $data);
            $this->load->view('pemilik/template/footer_pemilik');
        }
    }

    public function hapus($id)
    {
        $where = array('id_pegawai' => $id);
        $this->model_admin->delete('pegawai', $where);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
            <p class="text-light">Berhasil menghapus data</p>
            <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
        );
        redirect('pemilik/pegawai');
    }

    public function ubah($id)
    {
        $where = array('id_pegawai' => $id);
        $data['pegawai'] = $this->model_admin->get('pegawai', $where);

        $this->load->view('pemilik/template/header_pemilik');
        $this->load->view('pemilik/pegawai/pegawai_update', $data);
        $this->load->view('pemilik/template/footer_pemilik');
    }

    public function ubah_proses()
    {
        $id = $this->input->post('id_pegawai');
        $username = $this->input->post('username');
        $pass = $this->input->post('pass');
        $conf_pass = $this->input->post('conf_pass');
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $notelp = $this->input->post('notelp');

        if ($pass == $conf_pass) {
            $cekData = $this->model_admin->check_value('pegawai', 'username', $username);
            $getData = $this->model_admin->get_one('pegawai', $id, 'id_pegawai');

            if ($cekData == TRUE && $getData->username == $username) {
                $hasil = array(
                    'id_resto' => $this->session->id_resto,
                    'username' => $username,
                    'password' => $pass,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'notelp' => $notelp,
                    'aktif' => 1
                );
                
                $id_pegawai = array(
                    'id_pegawai' => $id
                );

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil mengubah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                $this->model_admin->update('pegawai', $hasil, $id_pegawai);
                redirect('pemilik/pegawai');
            } else if ($cekData == FALSE) {
                $hasil = array(
                    'id_resto' => $this->session->id_resto,
                    'username' => $username,
                    'password' => $pass,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'notelp' => $notelp,
                    'aktif' => 1
                );
                
                $id_pegawai = array(
                    'id_pegawai' => $id
                );

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil mengubah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                $this->model_admin->update('pegawai', $hasil, $id_pegawai);
                redirect('pemilik/pegawai');
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Username sudah ada</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                redirect('pemilik/pegawai/ubah/' . $id);
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
				<p class="text-light">Password tidak sama</p>
				<button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
			  </div>'
            );

            redirect('pemilik/pegawai/ubah/' . $id);
        }
    }

    public function ubah_status($id)
    {
        $stat = $this->model_admin->get_one('pegawai', $id, 'id_pegawai');

        if ($stat->aktif == 0) {
            $aktif = 1;
        } else {
            $aktif = 0;
        }

        $data = array(
            'aktif' => $aktif
        );

        $id = array(
            'id_pegawai' => $id
        );

        $this->model_admin->update('pegawai', $data, $id);
        redirect('pemilik/pegawai');
    }

    public function detail($id)
    {
        $where = array('id_pegawai' => $id);
        $data['pegawai'] = $this->model_admin->get('pegawai', $where);

        $this->load->view('pemilik/template/header_pemilik');
        $this->load->view('pemilik/pegawai/pegawai_detail', $data);
        $this->load->view('pemilik/template/footer_pemilik');
    }
}
