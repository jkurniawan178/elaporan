<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>E-Laporan - Login</title>

    <!-- iziToast CSS -->
    <link href="<?php echo base_url() ?>resources/iziToast/dist/css/iziToast.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="<?php echo base_url() ?>resources/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url() ?>resources/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 71px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }

        .footer {
            background-color: #008c4b;
        }
    </style>
</head>

<body class="vh-100">
    <section class="h-custom">
        <div class="container-fluid h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="<?php echo base_url("resources/images/coba.png"); ?>" class="img-fluid" alt="Login image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form>

                        <div class="divider d-flex align-items-center my-4">
                            <p class="lead fw-normal mb-0 me-3"><strong>LOGIN APLIKASI E-LAPORAN</strong></p>
                        </div>
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-center">
                            <p class="text-center fw-bold mx-3 mb-3">Mohon Masukan Username dan Password</p>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="username" class="form-control form-control-lg" placeholder="Enter Username" />
                            <label class="form-label" for="username">Username</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <input type="password" id="password" class="form-control form-control-lg" placeholder="Enter password" />
                            <label class="form-label" for="password">Password</label>
                        </div>

                        <div class="text-center text-md-left mt-4 pt-2">
                            <button type="button" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="mt-3 mt-lg-0 footer">
        <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5">
            <!-- Copyright -->
            <div class="text-white mb-3 mb-md-0">
                Hak Cipta © Pengadilan Tinggi Agama Maluku Utara 2023
            </div>
            <!-- Copyright -->
        </div>
    </footer>
    <!-- jQuery -->
    <script src="<?php echo base_url() ?>resources/jquery/dist/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
    <!-- Bootstrap -->
    <script src="<?php echo base_url() ?>resources/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- iziToast -->
    <script src="<?php echo base_url() ?>resources/iziToast/dist/js/iziToast.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url() ?>resources/js/custom.js"></script>
</body>