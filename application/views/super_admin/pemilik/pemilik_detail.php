<body class="g-sidenav-show   bg-gray-100" onload="setup()">
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
                    <a class="nav-link " href="<?= base_url('super_admin/admin') ?>">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('super_admin/pemilik') ?>" style="background-color: #F6F8FC;">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-shop text-success text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Pemilik</span>
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
                        <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="<?= base_url('super_admin/pemilik') ?>">Pemilik</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Detail Pemilik</li>
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

        <?php foreach ($pemilik as $pml) : ?>
            <div class="card shadow-lg mx-4 card-profile-top mt-4">
                <div class="card-body p-3">
                    <div class="row gx-4">
                        <div class="col-auto">
                            <div class="avatar avatar-xl position-relative">
                                <img src="<?= base_url() ?>assets/img/upload/restoran/<?= $pml->logo; ?>" alt="profile_image" class="w-100 h-100 border-radius-lg shadow-sm">
                            </div>
                        </div>
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <h3>
                                    <?= $pml->nama_pemilik; ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="horizontal dark">

            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 fs-5">Profil Akun</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="label text-sm">Username</label>
                                        <p class="mx-1 text-sm"><?= $pml->username; ?></p>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="label text-sm">Password</label>
                                        <div class="hstack gap-3">
                                            <input style="border-color: white; background-color: white; margin-left: -10px; margin-top: -10px;" class="form-control text-sm" id="pass" type="password" value="<?= $pml->password; ?>" disabled>
                                            <i class="fas fa-eye" id="ic_pass"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <?php if ($pml->aktif == 1) {
                                            $status = 'Aktif';
                                        } else {
                                            $status = 'Banned';
                                        } ?>
                                        <label class="label text-sm">Status</label>
                                        <p class="mx-1 text-sm"><?= $status; ?></p>
                                    </div>
                                </div>
                                <hr class="horizontal dark">
                                <p class="fs-5">Profil Restoran</p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="label text-sm">Nama Restoran</label>
                                        <p class="mx-1 text-sm"><?= $pml->nama; ?></p>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="label text-sm">Alamat</label>
                                        <p class="mx-1 text-sm"><?= $pml->alamat; ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4  pt-5">
                        <div class="card card-profile">
                            <img src="<?= base_url() ?>assets/img/upload/qrcode/<?= $pml->qrcode ?>" alt="Qrcode" class="card-img-top p-3">
                            <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                                <div class="d-flex justify-content-center">
                                    <a href="<?= base_url() ?>assets/img/upload/qrcode/<?= $pml->qrcode ?>" download class="btn btn-sm btn-dark mb-0 d-lg-block">Download</a>
                                </div>
                            </div>                            
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>

            <script>
                const ic_pass = document.querySelector("#ic_pass");
                const pass = document.querySelector("#pass");

                ic_pass.addEventListener("click", function() {
                    // toggle the type attribute
                    const type = pass.getAttribute("type") === "password" ? "text" : "password";
                    pass.setAttribute("type", type);

                    // toggle the icon
                    this.classList.toggle("fa-eye-slash");
                });
            </script>