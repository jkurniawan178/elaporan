<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Laporan - Login</title>
    <link rel="icon" href="images/favicon.ico" type="image/ico">
    <link href="resources/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <div class="col-md-9 pl-0 d-flex align-items-center "><img src="resources/images/logo1.png" class="img-fluid" alt="Login image"></div>
            </div>

            <h2 class="lead fw-normal my-2 me-3">Login</h2>
            <form class="login-form">
                <div class="form-outline mb-3">
                    <input type="text" id="username" class="form-control form-control-md" placeholder="Username" />
                    <!-- <label class="form-label" for="username">Username</label> -->
                </div>
                <!-- <input type="text" id="username" class="form-control" placeholder="Username"> -->
                <div class="form-outline mb-3">
                    <input type="password" id="password" class="form-control form-control-md" placeholder="Enter password" />
                    <!-- <label class="form-label" for="password">Password</label> -->
                </div>
                <div class="text-center text-md-left pt-2">
                    <button type="button" class="btn btn-primary btn-block">Login</button>
                </div>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>Hak Cipta © Pengadilan Tinggi Agama Maluku Utara 2023</p>
    </div>

    <script src="resources/jquery/dist/jquery.min.js"></script>
    <script src="resources/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="resources/js/custom.js"></script>
</body>

</html>