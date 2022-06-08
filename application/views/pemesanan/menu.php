    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0 hstack gap-3 d-flex justify-content-between">
              <h6>Daftar Menu</h6>
            </div>
            <div class="card-body pt-2 pb-0">

              <?= $this->session->flashdata('message') ?>

              <form action="<?= base_url('pesan/' . $id) ?>" method="post">
                <div class="hstack gap-3">
                  <input class="form-control" placeholder="Search" name="search" type="text">
                  <i class="fas fa-search" style="margin-left: -50px;"></i>
                </div>
              </form>

              <form action="<?= base_url('pesan/' . $id) ?>" method="post">
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
                            <?php if ($this->session->nama) { ?>
                              <div class="col-md-3 text-end">
                                <a href="<?= base_url('pemesanan/menu/beli/') . $mnu->id_menu ?>"><i class="fas fa-cart-plus text-success fs-3"></i></a>
                              </div>
                            <?php } ?>
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