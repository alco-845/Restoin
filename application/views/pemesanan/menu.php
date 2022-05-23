<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-250 bg-primary position-absolute w-100" style="height: 90px;"></div>
  <aside style="background-color: white;" class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a href="<?= base_url('pemesanan/menu') ?>" class="navbar-brand m-auto p-auto" style="font-size: x-large;">
        <span class="ms-1 font-weight-bold">Restoin</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse h-auto w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="<?= base_url('pemesanan/menu') ?>" style="background-color: #F6F8FC;">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fas fa-pizza-slice text-success text-sm opacity-10 mb-1"></i>
            </div>
            <span class="nav-link-text ms-1">Daftar Menu</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?= base_url('pemesanan/keranjang') ?>">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-cart text-secondary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Keranjang &nbsp;(<?= $this->cart->total_items() ?>)</span>
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
          <h5 class="font-weight-bolder text-white mb-0"><?= $this->session->nama_resto; ?></h5>
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Daftar Menu</li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
          <ul class="navbar-nav  justify-content-start">
            <li class="nav-item d-xl-none d-flex align-items-center" style="padding-right: 120px;">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-1 d-flex align-items-center">
              <p class="nav-link text-white m-auto fs-5"><?= $this->session->nama; ?></p>
            </li>
            <li class="nav-item px-1 d-flex align-items-center">
              <a href="<?= base_url('pemesanan/pesan/logout') ?>" class="nav-link text-white p-0 fs-5">
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
              <h6>Daftar Menu</h6>
            </div>
            <div class="card-body pt-2 pb-0">

              <?= $this->session->flashdata('message') ?>

              <form action="<?= base_url('pemesanan/menu') ?>" method="post">
                <div class="hstack gap-3">
                  <input class="form-control" placeholder="Search" name="search" type="text">
                  <i class="fas fa-search" style="margin-left: -50px;"></i>
                </div>
              </form>

              <form action="<?= base_url('pemesanan/menu') ?>" method="post">
                <select name="opsi" onchange="form.submit()" class="form-control mt-4">
                  <option <?php if ($opsi == 'Semua') echo "selected" ?> value="Semua">Semua</option>
                  <option <?php if ($opsi == 'Makanan') echo "selected" ?> value="Makanan">Makanan</option>
                  <option <?php if ($opsi == 'Minuman') echo "selected" ?> value="Minuman">Minuman</option>
                  <option <?php if ($opsi == 'Snack') echo "selected" ?> value="Snack">Snack</option>
                </select>
              </form>

              <div class="row">
                <?php
                if ($menu == null) {
                  echo '<p class="text-center mt-5 mb-5">Tidak Ada Data</p>';
                } else {
                  foreach ($menu as $mnu) : ?>
                    <div class="col-lg-6">
                      <div class="card mt-3 mb-5">

                        <div class="card-body">

                          <div class="row align-items-center">
                            <div class="col-md-4">
                              <img src="<?= base_url() ?>assets/img/upload/menu/<?= $mnu->foto ?>" alt="Foto" class="card-img-top p-3 img-fluid">
                            </div>
                            <div class="col-md-5">
                              <h4 class="mx-1 text-m"><?= $mnu->menu; ?></h4>
                              <p class="mx-1 text-sm">Rp. <?= $mnu->harga; ?></p>
                            </div>
                            <div class="col-md-3 text-end">
                              <a href="<?= base_url('pemesanan/menu/beli/') . $mnu->id_menu ?>"><i class="fas fa-cart-plus text-success fs-3"></i></a>
                            </div>
                          </div>

                        </div>

                      </div>
                    </div>
                <?php
                  endforeach;
                } ?>

              </div>

            </div>

          </div>
        </div>

      </div>