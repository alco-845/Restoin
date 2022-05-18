<main class="main-content  mt-0" style="background-color: #DFE0E5;">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">

                    <div class="col-4"></div>

                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card z-index-0">
                            <div class="card-header text-center pt-4" style="margin-bottom: -25px;">
                                <h4 class="font-weight-bolder">Login Admin</h4>
                            </div>
                            <div class="card-body">
                                <?= $this->session->flashdata('message') ?>
                                <form action="<?= base_url('login/auth_admin') ?>" method="post">
                                    <div class="mb-3">
                                        <input type="text" class="form-control form-control-lg" placeholder="Username" aria-label="Username" name="username" required>
                                    </div>
                                    <div class="mb-3 hstack gap-3">
                                        <input type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" id="password" name="password" required>
                                        <i class="fas fa-eye" id="ic_password" style="margin-left: -50px;"></i>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-lg w-100 mt-4 mb-0" style="background-color: #75A7F9; color: white;">Login</button>
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
<script>
    const ic_password = document.querySelector("#ic_password");
    const password = document.querySelector("#password");

    ic_password.addEventListener("click", function() {
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // toggle the icon
        this.classList.toggle("fa-eye-slash");
    });
</script>
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