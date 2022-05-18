<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-250 bg-primary position-absolute w-100" style="height: 90px;"></div>
  <aside style="background-color: white;" class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a href="<?= base_url('super_admin/dashboard') ?>" class="navbar-brand m-auto p-auto" style="font-size: x-large;">
        <span class="ms-1 font-weight-bold">Restoin</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse h-auto w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link " href="<?= base_url('super_admin/dashboard') ?>">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="<?= base_url('super_admin/admin') ?>" style="background-color: #F6F8FC;">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Admin</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?= base_url('super_admin/pemilik') ?>">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-shop text-success text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Pemilik Restoran</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h5 class="font-weight-bolder text-white mb-0">Super Admin</h5>
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Admin</li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
          <ul class="navbar-nav  justify-content-start">
            <li class="nav-item d-xl-none d-flex align-items-center" style="padding-right: 50%;">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-1 d-flex align-items-center">
              <p class="nav-link text-white m-auto fs-5"><?= $this->session->username; ?></p>
            </li>
            <li class="nav-item px-1 d-flex align-items-center">
              <a href="<?= base_url('super_admin/dashboard/logout') ?>" class="nav-link text-white p-0 fs-5">
                <i class="fa fa-sign-out"></i>
              </a>
            </li>
          </ul>
          </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0 hstack gap-3 d-flex justify-content-between">
              <h6>Daftar Admin</h6>
              <a type="button" class="btn btn-info ml-4" href="<?= base_url('super_admin/admin/tambah') ?>" role="button"><i class="fas fa-plus fa-sm"></i>&nbsp; Tambah</a>
            </div>
            <div class="card-body pt-2 pb-0">
              <?= $this->session->flashdata('message') ?>

              <form action="<?= base_url('super_admin/admin') ?>" method="post">
                <div class="hstack gap-3">
                  <input class="form-control" placeholder="Search" name="search" type="text">
                  <i class="fas fa-search" style="margin-left: -50px;"></i>
                </div>
              </form>

              <div class="table-responsive p-0 mt-4">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-5">
                  <thead align="center">
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" colspan="2">Action</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    </tr>
                  </thead>

                  <?php
                  if ($admin == null) {
                    echo '
                                <tbody>
                                <tr>
                                <td colspan="6" style="text-align: center;">Tidak Ada Data</td>
                                </tr>
                                </tbody>                
                                </table>
                                ';
                  } else {
                    $no = $this->uri->segment('4') + 1;
                    foreach ($admin as $adm) : 
                      if ($adm->aktif == 1) {
                        $status = 'Aktif';
                        $warna = 'text-info';
                    } else {
                        $status = 'Banned';
                        $warna = 'text-warning';
                    }?>

                      <tbody align="center">
                        <tr style="border-bottom: 1px solid lightgrey;">
                          <td><?= $no++; ?></td>
                          <td><?= $adm->username ?></td>
                          <td><?= $adm->email ?></td>

                          <td><?= anchor('super_admin/admin/ubah/' . $adm->id_admin, '<div class="btn btn-success btn-m"><i class="fa fa-edit"></i></div>') ?></td>
                          <?php if ($adm->id_admin == $this->session->id_admin) : ?>
                            <td><div class="btn btn-danger btn-m opacity-5" disabled><i class="fa fa-trash"></i></div></td>
                            <td><div class='" <?= $warna; ?> " opacity-5' disabled><?= $status; ?></div></td>
                          <?php else : ?>
                            <td onclick="javasript: return confirm('Anda yakin ingin menghapus data ini?')"><?= anchor('super_admin/admin/hapus/' . $adm->id_admin, '<div class="btn btn-danger btn-m"><i class="fa fa-trash"></i></div>') ?></td>
                            <td><?= anchor('super_admin/admin/ubah_status/'.$adm->id_admin,'<div class="'.$warna.'">'.$status.'</div>') ?></td>
                          <?php endif; ?>                          

                        </tr>
                      <?php
                    endforeach; ?>
                      </tbody>
                    <?php
                  }
                    ?>

                </table>
              </div>
            </div>
          </div>
          </div>

          <div class="row mb-4">
            <div class="col-4"></div>

            <div class="col-4">
              <?= $pagination; ?>
            </div>

            <div class="col-4"></div>
          </div>

        </div>
      </div>

    </div>