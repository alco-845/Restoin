<body class="g-sidenav-show   bg-gray-100" onload="setup()">
    <div class="min-height-250 bg-primary position-absolute w-100" style="height: 90px;"></div>
    <aside style="background-color: white;" class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a href="<?= base_url('pemilik/dashboard') ?>" class="navbar-brand m-auto p-auto" style="font-size: x-large;">
                <span class="ms-1 font-weight-bold">Restoin</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse h-auto w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link " href="<?= base_url('pemilik/dashboard') ?>">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('pemilik/menu') ?>" style="background-color: #F6F8FC;">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-pizza-slice text-success text-sm opacity-10 mb-1"></i>
                        </div>
                        <span class="nav-link-text ms-1">Menu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?= base_url('pemilik/pegawai') ?>">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pegawai</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?= base_url('pemilik/meja') ?>">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-utensils text-info text-sm opacity-10 mb-1"></i>
                        </div>
                        <span class="nav-link-text ms-1">Meja</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?= base_url('pemilik/transaksi') ?>">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-cart text-secondary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Transaksi Hari Ini</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?= base_url('pemilik/laporan') ?>">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-chart-bar-32 text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Laporan</span>
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
                    <h5 class="font-weight-bolder text-white mb-0">Pemilik</h5>
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                        <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="<?= base_url('pemilik/menu') ?>">Menu</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Ubah Menu</li>
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
                            <a href="<?= base_url('pemilik/dashboard/logout') ?>" class="nav-link text-white p-0 fs-5">
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
                            <h6>Ubah Menu</h6>
                        </div>
                        <div class="card-body">

                            <?= $this->session->flashdata('message') ?>

                            <?php foreach ($menu as $mnu) : ?>

                                <form action="<?= base_url('pemilik/menu/ubah_proses') ?>" method="post" enctype="multipart/form-data">
                                    <div class="row">

                                    <input class="form-control" name="id_menu" type="hidden" value="<?= $mnu->id_menu; ?>">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kategori" class="form-control-label">kategori</label>
                                                <select name="kategori" class="form-control">
                                                    <option <?php if ($mnu->kategori == 'Makanan') echo "selected" ?> value="Makanan">Makanan</option>
                                                    <option <?php if ($mnu->kategori == 'Minuman') echo "selected" ?> value="Minuman">Minuman</option>
                                                    <option <?php if ($mnu->kategori == 'Snack') echo "selected" ?> value="Snack">Snack</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="menu" class="form-control-label">Menu</label>
                                                <input class="form-control" id="menu" name="menu" type="text" value="<?= $mnu->menu; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="harga" class="form-control-label">Harga</label>
                                                <input class="form-control" id="harga" name="harga" type="number" min="0" value="<?= $mnu->harga; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="foto" class="form-control-label">Foto</label>
                                                <div class="hstack gap-3">
                                                    <input style="margin-bottom: 20px;" class="form-control" type="text" id="foto" name="foto" disabled>
                                                    <input class="form-control" id='foto_file' type='file' name='foto_file' hidden />
                                                    <input class="btn btn-secondary btn-sm" style="margin-left: -125px; margin-bottom: 20px;" id='buttonid' type='button' value='Upload' />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-4">
                                            <div class="form-group">
                                                <input type="submit" name="submit" value="Ubah" class="btn btn-success btn-sm btn-block w-100 fs-5">
                                            </div>
                                        </div>

                                    </div>
                                </form>

                            <?php endforeach; ?>

                        </div>

                    </div>
                </div>

            </div>


            <script>
                function setup() {
                    document.getElementById('buttonid').addEventListener('click', openDialog);

                    function openDialog() {
                        document.getElementById('foto_file').click();
                    }
                    document.getElementById('foto_file').addEventListener('change', changeInput);

                    function changeInput() {
                        var input = document.getElementById("foto_file");
                        var file = input.value.split("\\");
                        var fileName = file[file.length - 1];

                        document.getElementById('foto').value = fileName;
                    }
                }
            </script>