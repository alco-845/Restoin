<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 hstack gap-3 d-flex justify-content-between">
                    <h6>Daftar Transaksi</h6>
                </div>
                <div class="card-body pt-2 pb-0">

                    <div class="table-responsive p-0 mt-4">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-4">
                                <thead align="center">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bayar</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kembali</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pembayaran</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Detail</th>
                                    </tr>
                                </thead>
                                <?php
                                if ($transaksi == null) {
                                    echo '
                                <tbody>
                                <tr>
                                <td colspan="8" style="text-align: center;">Tidak Ada Data</td>
                                </tr>
                                </tbody>                
                                </table>
                                ';
                                } else {
                                    $no = 1;                                    
                                    foreach ($transaksi as $trans) :
                                        if ($trans->id_penjualan == $this->session->userdata('transaksi_' . $trans->id_penjualan)) { ?>
                                            <tbody align="center">
                                                <tr style="border-bottom: 1px solid lightgrey;">
                                                    <td><?= $no++; ?></td>
                                                    <td>Rp. <?= $trans->total ?></td>
                                                    <td>Rp. <?= $trans->bayar ?></td>
                                                    <td>Rp. <?= $trans->kembali ?></td>
                                                    <td><?= $trans->metode_pembayaran ?></td>
                                                    <td><?= $trans->status ?></td>
                                                    <td><?= anchor('pemesanan/transaksi/detail/' . $trans->id_penjualan, '<div class="btn btn-warning btn-m"><i class="fa fa-info"></i></div>') ?></td>
                                                </tr>
                                            </tbody>
                                    <?php
                                        }
                                    endforeach; ?>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>