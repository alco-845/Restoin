        <?php foreach ($transaksi as $trans) : ?>
            <div class="card shadow-lg mx-4 card-profile-top mt-4">
                <div class="card-body p-3">
                    <div class="row gx-4">
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <h3>
                                    <?= $trans->no_faktur; ?> |
                                    <?= $trans->tanggal; ?> |
                                    <?= $trans->pelanggan; ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="horizontal dark">

            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-8">
                        <?php
                        $no = 1;
                        foreach ($item as $itm) : ?>
                            <div class="card mt-3 mb-3">

                                <div class="card-body">

                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-1">
                                            <p class="mx-1 text-sm"><?= $no++; ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <img src="<?= base_url() ?>assets/img/upload/menu/<?= $itm->foto ?>" alt="Foto" class="card-img-top p-3 img-fluid">
                                        </div>
                                        <div class="col-md-5">
                                            <h4 class="mx-1 text-m"><?= $itm->menu; ?></h4>
                                            <p class="mx-1 text-sm">Qty: <?= $itm->jumlah; ?></p>
                                            <p class="mx-1 text-sm">Harga: Rp. <?= $itm->harga; ?></p>
                                            <p class="mx-1 text-sm">Subtotal: Rp. <?= $itm->subtotal; ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="mx-1 text-sm">Status: <?= $itm->status; ?></p>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="col-md-4 pt-3 pb-3">
                        <div class="card">

                            <div class="card-body border-0 pt-4 pt-lg-3 pb-2 pb-lg-3">
                                <p>Meja: <?= $trans->nomer_meja; ?></p>
                                <p>Metode Pembayaran: <?= $trans->metode_pembayaran; ?></p>
                                <p>Status: <?= $trans->status; ?></p>
                                <p>Total: Rp. <?= $trans->total; ?></p>
                                <p>Bayar: Rp. <?= $trans->bayar; ?></p>
                                <p>Kembali: Rp. <?= $trans->kembali; ?></p>
                            </div>

                        </div>
                    </div>

                </div>

            <?php endforeach; ?>