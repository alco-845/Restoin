<?php

class Menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_admin');
    }

    public function index()
    {
        $id = $this->session->id_resto;
        $config['base_url'] = site_url('pemilik/menu/index');
        $config['total_rows'] = $this->model_admin->count_one('menu', 'id_resto', $id);
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
            $data['menu'] = $this->model_admin->get_keyword('menu', 'id_resto', $id, 'menu', $search, 'menu', 'asc');
            $data['opsi'] = "Semua";
            $data['pagination'] = "";
        } else {
            if ($this->input->post('opsi') == 'Makanan' || $this->input->post('opsi') == 'Minuman' || $this->input->post('opsi') == 'Snack') {
                $data['opsi'] = $this->input->post('opsi');
    
                $data['menu'] = $this->model_admin->get_keyword('menu', 'id_resto', $id, 'kategori', $data['opsi'], 'menu', 'asc');
                $data['pagination'] = "";
            } else {
                $data['opsi'] = "Semua";
    
                $data['menu'] = $this->model_admin->get_where_ordered('menu', 'id_resto', $id, 'menu', 'asc', $config["per_page"], $data['page']);
                $data['pagination'] = $this->pagination->create_links();
            } 
        }

        $this->load->view('pemilik/template/header_pemilik');
        $this->load->view('pemilik/menu/menu_select', $data);
        $this->load->view('pemilik/template/footer_pemilik');
    }

    public function tambah()
    {
        $this->load->view('pemilik/template/header_pemilik');
        $this->load->view('pemilik/menu/menu_insert');
        $this->load->view('pemilik/template/footer_pemilik');
    }

    public function tambah_proses()
    {
        $id_resto = $this->session->id_resto;
        $kategori = $this->input->post('kategori');
        $menu = $this->input->post('menu');
        $harga = $this->input->post('harga');

        $foto = $this->input->post('foto_file');

        $foto = $id_resto . '_' . time() . '_' . $_FILES['foto_file']['name'];
        $config['upload_path'] = './assets/img/upload/menu';
        $config['allowed_types'] = 'jpg|png|jpeg';

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('foto_file')) {
            $foto = "default.jpg";
        } else {
            $foto = $this->upload->data('file_name');
        }

        $hasil = array(
            'id_resto' => $id_resto,
            'kategori' => $kategori,
            'menu' => $menu,
            'harga' => $harga,
            'foto' => $foto,
        );

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil menambah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
        );

        $this->model_admin->insert("menu", $hasil);
        redirect('pemilik/menu');
    }

    public function hapus($id)
    {
        $get = $this->model_admin->get_one('menu', $id, 'id_menu');
        unlink('./assets/img/upload/menu/' . $get->foto);

        $where = array('id_menu' => $id);
        $this->model_admin->delete('menu', $where);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
            <p class="text-light">Berhasil menghapus data</p>
            <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
        );
        redirect('pemilik/menu');
    }

    public function ubah($id)
    {
        $where = array('id_menu' => $id);
        $data['menu'] = $this->model_admin->get('menu', $where);

        $this->load->view('pemilik/template/header_pemilik');
        $this->load->view('pemilik/menu/menu_update', $data);
        $this->load->view('pemilik/template/footer_pemilik');
    }

    public function ubah_proses()
    {
        $id_menu = $this->input->post('id_menu');
        $kategori = $this->input->post('kategori');
        $menu = $this->input->post('menu');
        $harga = $this->input->post('harga');

        $foto_file = $_FILES['foto_file'];        

        $get = $this->model_admin->get_one('menu', $id_menu, 'id_menu');
        $tmp = $_FILES['foto_file']['tmp_name'];
        if (!empty($tmp)) {
            $foto_file = $get->id_resto . '_' . time() . '_' . $_FILES['foto_file']['name'];
            move_uploaded_file($tmp, './assets/img/upload/menu/' . $foto_file);
            if ($get->foto != "default.jpg") {
                unlink('./assets/img/upload/menu/' . $get->foto);
            }
        } else {
            $foto_file = $get->foto;
        }

        $hasil = array(
            'kategori' => $kategori,
            'menu' => $menu,
            'harga' => $harga,
            'foto' => $foto_file
        );

        $id_menu_array = array(
            'id_menu' => $id_menu
        );

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil mengubah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
        );

        $this->model_admin->update('menu', $hasil, $id_menu_array);
        redirect('pemilik/menu');
    }    
}
