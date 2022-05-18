<?php

class Meja extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_admin');
    }

    public function index()
    {
        $id = $this->session->id_resto;
        $config['base_url'] = site_url('pemilik/meja/index');
        $config['total_rows'] = $this->model_admin->count_one('meja', 'id_resto', $id);
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
            $data['meja'] = $this->model_admin->get_keyword('meja', 'id_resto', $id, 'nomer', $search, 'nomer', 'asc');
            $data['opsi'] = "Semua";
            $data['pagination'] = "";
        } else {
            if ($this->input->post('opsi') == 'Tersedia' || $this->input->post('opsi') == 'Dipakai') {
                $data['opsi'] = $this->input->post('opsi');
    
                $data['meja'] = $this->model_admin->get_keyword('meja', 'id_resto', $id, 'status', $data['opsi'], 'nomer', 'asc');
                $data['pagination'] = "";
            } else {
                $data['opsi'] = "Semua";
    
                $data['meja'] = $this->model_admin->get_where_ordered('meja', 'id_resto', $id, 'nomer', 'asc', $config["per_page"], $data['page']);
                $data['pagination'] = $this->pagination->create_links();
            }
        }

        $this->load->view('pemilik/template/header_pemilik');
        $this->load->view('pemilik/meja/meja_select', $data);
        $this->load->view('pemilik/template/footer_pemilik');
    }

    public function tambah()
    {
        $this->load->view('pemilik/template/header_pemilik');
        $this->load->view('pemilik/meja/meja_insert');
        $this->load->view('pemilik/template/footer_pemilik');
    }

    public function tambah_proses()
    {
        $id_resto = $this->session->id_resto;
        $nomer = $this->input->post('nomer');
    
        $hasil = array(
            'id_resto' => $id_resto,
            'nomer' => $nomer,
            'status' => 'Tersedia',
        );

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil menambah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
        );

        $this->model_admin->insert("meja", $hasil);
        redirect('pemilik/meja');
    }

    public function hapus($id)
    {
        $where = array('id_meja' => $id);
        $this->model_admin->delete('meja', $where);

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
            <p class="text-light">Berhasil menghapus data</p>
            <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>'
        );
        redirect('pemilik/meja');
    }

    public function ubah($id)
    {
        $where = array('id_meja' => $id);
        $data['meja'] = $this->model_admin->get('meja', $where);

        $this->load->view('pemilik/template/header_pemilik');
        $this->load->view('pemilik/meja/meja_update', $data);
        $this->load->view('pemilik/template/footer_pemilik');
    }

    public function ubah_proses()
    {
        $id_meja = $this->input->post('id_meja');        
        $nomer = $this->input->post('nomer');

        $hasil = array(
            'nomer' => $nomer
        );

        $id_meja_array = array(
            'id_meja' => $id_meja
        );

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="height: 60px;">
                    <p class="text-light">Berhasil mengubah data</p>
                    <button type="button" class="btn-close w-100 h-100" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>'
        );

        $this->model_admin->update('meja', $hasil, $id_meja_array);
        redirect('pemilik/meja');
    }    

    public function ubah_status($id)
    {
        $stat = $this->model_admin->get_one('meja', $id, 'id_meja');

        if ($stat->status == 'Dipakai') {
            $status = 'Tersedia';
        } else {
            $status = 'Dipakai';
        }

        $data = array(
            'status' => $status
        );

        $id = array(
            'id_meja' => $id
        );

        $this->model_admin->update('meja', $data, $id);
        redirect('pemilik/meja');
    }
}
