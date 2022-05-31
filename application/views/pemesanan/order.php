<main class="main-content  mt-0" style="background-color: #DFE0E5;">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">

                    <div class="col-4"></div>

                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card z-index-0">
                            <div class="card-header text-center pt-4" style="margin-bottom: -25px;">
                                <h4 class="font-weight-bolder"><?= $resto->nama; ?></h4>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('pemesanan/order/login') ?>" method="post">
                                <input type="hidden" name="id_resto" value="<?= $resto->id_resto; ?>">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="nama" class="form-control-label">Atas Nama</label>
                                            <input type="text" class="form-control form-control-lg" aria-label="Nama" name="nama" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="meja" class="form-control-label">Meja Tersedia</label>
                                            <select name="meja" class="form-control">
                                                <?php foreach ($meja as $mej) : ?>
                                                    <option value="<?= $mej->id_meja ?>"><?= $mej->nomer ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-lg w-100 mt-4 mb-0" style="background-color: #75A7F9; color: white;">Mulai Memesan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-4"></div>

                </div>
            </div>
        </div>
    </section>
</main>

<!--   Core JS Files   -->
<script src="<?= base_url() ?>assets/js/core/popper.min.js"></script>
<script src="<?= base_url() ?>assets/js/core/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="<?= base_url() ?>assets/js/plugins/smooth-scrollbar.min.js"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?= base_url() ?>assets/js/argon-dashboard.min.js?v=2.0.2"></script>
</body>

</html>