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
                    <a class="nav-link " href="<?= base_url('pemesanan/menu') ?>">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-pizza-slice text-success text-sm opacity-10 mb-1"></i>
                        </div>
                        <span class="nav-link-text ms-1">Daftar Menu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('pemesanan/keranjang') ?>" style="background-color: #F6F8FC;">
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
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Keranjang</li>
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
                            <h6>Keranjang</h6>
                        </div>
                        <div class="card-body pt-2 pb-0">

                            <div class="table-responsive p-0 mt-4">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-4">
                                        <thead align="center">
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Menu</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hapus</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        if ($cart == null) {
                                            echo '
                                <tbody>
                                <tr>
                                <td colspan="6" style="text-align: center;">Tidak Ada Data</td>
                                </tr>
                                </tbody>                
                                </table>
                                ';
                                        } else {
                                            $total = 0;
                                            $no = 1;
                                            foreach ($cart as $item) : ?>
                                                <tr style="text-align: center;">
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $item['name'] ?></td>
                                                    <td>Rp. <?php echo $item['price'] ?></td>
                                                    <td>
                                                        <?php echo anchor('pemesanan/keranjang/beli_tambah/' . $item['rowid'], '<i class="fa fa-plus-circle text-success fs-4"></i>'); ?>&nbsp;&nbsp;
                                                        <input style="width:50px; text-align:center;" type="text" disabled value="<?php echo $item['qty'] ?>">&nbsp;&nbsp;
                                                        <?php echo anchor('pemesanan/keranjang/beli_kurang/' . $item['rowid'], '<i class="fa fa-minus-circle text-success fs-4"></i>'); ?>
                                                    </td>
                                                    <td><a class="btn btn-danger btn-m mt-3" href="<?= base_url('pemesanan/keranjang/beli_hapus/') . $item['rowid'] ?>"><i class="fa fa-trash"></i></a></td>
                                                    <td>Rp. <?php echo $item['subtotal'] ?></td>
                                                </tr>
                                            <?php

                                                $total = $total + $item['subtotal'];

                                            endforeach; ?>
                                            <tr>
                                                <td colspan="5">
                                                    <h3>Total :</h3>
                                                </td>

                                                <td style="text-align: center;">
                                                    <h4>Rp. <?= $total ?></h4>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="6"><?php if (!empty($total)) { ?>
                                        <div class="text-end mt-4" onclick="javasript: return confirm('Anda yakin ingin melakukan checkout? Pastikan keranjang anda sudah benar')"><?= anchor('pemesanan/keranjang/checkout', '<div class="btn btn-info btn-m">Checkout</div>') ?></div>
                                    <?php } ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>                                    

                                </div>

                            </div>

                        </div>
                    </div>

                </div>