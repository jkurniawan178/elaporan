<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Laporan - Login</title>
    <link rel="icon" href="images/favicon.ico" type="image/ico">
    <link href="<?php echo base_url() ?>resources/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url() ?>resources/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #008c4b, #50b548);
        }

        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: calc(100vh - 72px);
        }

        .login-card {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .logo-image {
            max-width: 50px !important;
            height: auto;
        }

        @media (max-width: 768px) {
            .h-custom {
                height: 100%;
            }
        }

        .footer {
            color: white;
            text-align: center;
            padding: 1rem 0;
            height: 72px;
        }
    </style>
</head>

<body class="min-vh-100">
    <div class="login-container">
        <div class="login-card">
            <div class="row mb-4">
                <div class="col-md-3 pr-0 d-flex align-items-center "><img src="resources/images/logo.png" class="logo-image" alt=""></div>
                <div class="col-md-9 pl-0 d-flex align-items-center "><img src="resources/images/logo2.png" class="img-fluid" alt="Login image"></div>
            </div>
            <?php echo $this->session->flashdata('error_msg') ?>
            <h2 class="lead fw-normal my-2 me-3">Login</h2>
            <form class="login-form needs-validation" action="<?php echo base_url() . 'masuk/signin' ?>" method="post" novalidate>
                <div class="item form-group">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-user fa-lg"></i></div>
                        </div>
                        <input type="text" id="userName" name="userName" required class="form-control" placeholder="Username">
                        <div class="invalid-feedback">
                            Username Tidak Boleh Kosong
                        </div>
                    </div>
                </div>
                <div class="item form-group">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-key"></i></div>
                        </div>
                        <input type="password" id="password" name="password" required class="form-control" placeholder="Password">
                        <div class="invalid-feedback">
                            Password Tidak Boleh Kosong
                        </div>
                    </div>
                </div>

                <div class="text-center text-md-left pt-2">
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>Hak Cipta © Pengadilan Tinggi Agama Maluku Utara 2023</p>
    </div>

    <script src="<?php echo base_url() ?>resources/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>resources/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url() ?>resources/js/custom.js"></script>
    <script>
        //Function that using bootstrap validator
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>