<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="login-style.css" />


    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />

</head>

<body>
<div class="home-container">
    <div class="home-container1">
        <img alt="pastedImage" src="/rajlogo.png" loading="eager" class="home-pasted-image" />
        <div class="home-container2">
            <div class="home-text">
                <div>Sales &amp; Inventory</div>
                <div>System</div>
                <br />
            </div>
            <div class="container-fluid login-error">
            <?php if (isset($data)): ?>
              <div class="alert alert-danger">
                <?= $data ?>
              </div>
            <?php endif ?>
          </div>
            <form class="home-form" action="<?php echo base_url('login'); ?>" method="POST" >
                <div class="mb-3">
                    <label for="username" class="form-label fw-bold">Username</label>
                    <input type="text" class="form-control mb-1 home-textinput" id="username" name="username" required />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <input type="password" class="form-control mb-1 home-textinput1" id="password" name="password" required />
                </div>
                <button type="submit" class="home-button button">LOGIN</button>
            </form>
            <a href="https://example.com" target="_blank" rel="noreferrer noopener" class="home-link">
                Forgot Password
            </a>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/f38a62f9ed.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

</body>

</html>