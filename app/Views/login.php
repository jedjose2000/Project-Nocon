<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raj's Pet Shop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <!-- 
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="login-style.css" />

</head>

<body>
    <div class="container main-container">
        <div class="container bg-white rounded">
            <div class="row">
                <div class="col-md-9 col-lg-6 col-xl-5 image-container">
                    <img src="/picture/rajlogo.png" class="img-fluid" alt="Raj Image">
                </div>
                <div class="col  d-flex justify-content-center align-items-center">
                    <div class="p-3">
                        <form id="loginForm" action="<?php echo base_url('login'); ?>" method="POST">
                            <div class="text-center mb-5">
                                <p class="lead mb-0 me-3 fs-1 fw-bold">Sales and Inventory System</p>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label fw-bold" for="form3Example3">Username</label>
                                <input type="text" name="username" id="form3Example3" class="form-control form-control"
                                    placeholder="Enter username" required />
                            </div>
                            <div class="form-outline mb-3">
                                <label class="form-label fw-bold" for="form3Example4">Password</label>
                                <input type="password" name="password" id="form3Example4"
                                    class="form-control form-control" placeholder="Enter password" required />
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <a href="<?php echo base_url('forgot-password') ?>"
                                    class="forgot-password text-body fw-bold">Forgot password?</a>
                            </div>
                            <div class="text-center mt-4 pt-2">
                                <button type="submit" class="btn btn-primary "
                                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>