<?php

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_admin');
    }

    public function index()
    {
        $config['base_url'] = site_url('super_admin/admin/index');
        $config['total_rows'] = $this->model_admin->count_one('admin', 'level', 'Admin');
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
            $data['admin'] = $this->model_admin->get_keyword('admin', 'level', 'Admin', 'username', $search, 'username', 'asc');
            $data['pagination'] = "";
        } else {
            $data['admin'] = $this->model_admin->get_where_ordered('admin', 'level', 'Admin', 'username', 'asc', $config["per_page"], $data['page']);
            $data['pagination'] = $this->pagination->create_links();
        }


        $this->load->view('super_admin/template/header_admin');
        $this->load->view('super_admin/admin/admin_select', $data);
        $this->load->view('super_admin/template/footer_admin');
    }

    public function tambah()
    {
        $data['input_data'] = array(
            '',
            '',
            '',
            '',
        );

        $this->load->view('super_admin/template/header_admin');
        $this->load->view('super_admin/admin/admin_insert', $data);
        $this->load->view('super_admin/template/footer_admin');
    }

    public function tambah_proses()
    {
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $pass = $this->input->post('pass');
        $conf_pass = $this->input->post('conf_pass');

        $data['input_data'] = array(
            $username,
            $email,
            $pass,
            $conf_pass,
        );

        if ($pass == $conf_pass) {
            $getData = $this->model_admin->get_one('admin', $username, 'username');

            if ($getData == FALSE) {
                $hasil = array(
                    'id_resto' => 0,
                    'username' => $username,
                    'email' => $email,
                    'password' => $pass,
                    'level' => 'Admin',
                    'aktif' => 1
                );

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil menambah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                $this->model_admin->insert("admin", $hasil);
                redirect('super_admin/admin');
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Username sudah ada</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                $this->load->view('super_admin/template/header_admin');
                $this->load->view('super_admin/admin/admin_insert', $data);
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
            $this->load->view('super_admin/admin/admin_insert', $data);
            $this->load->view('super_admin/template/footer_admin');
        }
    }

    public function hapus($id)
    {
        $where = array('id_admin' => $id);
        $this->model_admin->delete('admin', $where);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
            <p class="text-light">Berhasil menghapus data</p>
            <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
        );
        redirect('super_admin/admin');
    }

    public function ubah($id)
    {
        $where = array('id_admin' => $id);
        $data['admin'] = $this->model_admin->get('admin', $where);

        $this->load->view('super_admin/template/header_admin');
        $this->load->view('super_admin/admin/admin_update', $data);
        $this->load->view('super_admin/template/footer_admin');
    }

    public function ubah_proses()
    {
        $id = $this->input->post('id_admin');
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $pass = $this->input->post('pass');
        $conf_pass = $this->input->post('conf_pass');

        if ($pass == $conf_pass) {
            $cekData = $this->model_admin->check_value('admin', 'username', $username);
            $getData = $this->model_admin->get_one('admin', $id, 'id_admin');

            if ($cekData == TRUE && $getData->username == $username) {
                $hasil = array(
                    'id_resto' => 0,
                    'username' => $username,
                    'email' => $email,
                    'password' => $pass,
                    'level' => 'Admin',
                    'aktif' => 1
                );

                if ($id == $this->session->id_admin) {
                    $this->session->set_userdata(
                        array(
                            'id_admin' => $id,
                            'username' => $username,
                            'email' => $email,
                            'level' => 'Admin'
                        )
                    );
                }

                $id_admin = array(
                    'id_admin' => $id
                );

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil mengubah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                $this->model_admin->update('admin', $hasil, $id_admin);
                redirect('super_admin/admin');
            } else if ($cekData == FALSE) {
                $hasil = array(
                    'id_resto' => 0,
                    'username' => $username,
                    'email' => $email,
                    'password' => $pass,
                    'level' => 'Admin',
                    'aktif' => 1
                );

                if ($id == $this->session->id_admin) {
                    $this->session->set_userdata(
                        array(
                            'id_admin' => $id,
                            'username' => $username,
                            'email' => $email,
                            'level' => 'Admin'
                        )
                    );
                }

                $id_admin = array(
                    'id_admin' => $id
                );

                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil mengubah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                $this->model_admin->update('admin', $hasil, $id_admin);
                redirect('super_admin/admin');
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Username sudah ada</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
                );

                redirect('super_admin/admin/ubah/' . $id);
            }
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
				<p class="text-light">Password tidak sama</p>
				<button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
			  </div>'
            );

            redirect('super_admin/admin/ubah/' . $id);
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
        redirect('super_admin/admin');
    }
}
