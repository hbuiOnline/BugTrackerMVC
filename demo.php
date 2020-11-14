<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Bug Tracker - DEMO Login</title>
  <link rel="shortcut icon" type="image/x-icon" href="img/bugLogo.png" />

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="style/style.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Pick A User</h1>
                  </div>

                  <div class="row">
                    <div class="col-lg-6">
                      <form class="user" action="includes/login.inc.php" method="POST">
                        <input type="hidden" name="demousername" value="admindemo">
                        <button class="demo-user" type="submit" name="admin-login-submit">
                          <img src="img/admin_profile.svg" class="img-fluid px3 px-sm4 mt-3 mb4" style="width:10rem;" alt="">
                        </button>
                        <p class="text-center">Admin</p>
                      </form>
                    </div>
                    <div class="col-lg-6">
                      <form class="user" action="includes/login.inc.php" method="POST">
                        <input type="hidden" name="demousername" value="projectmanagerdemo">
                        <button class="demo-user" type="submit" name="projectmanager-login-submit">
                          <img src="img/projectmanager_profile.svg" class="img-fluid px3 px-sm4 mt-3 mb4" style="width:10rem;" alt="">
                        </button>
                        <p class="text-center">Project Manager</p>
                      </form>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6">
                      <form class="user" action="includes/login.inc.php" method="POST">
                        <input type="hidden" name="demousername" value="developerdemo">
                        <button class="demo-user" type="submit" name="dev-login-submit">
                          <img src="img/dev2_profile.svg" class="img-fluid px3 px-sm4 mt-3 mb4" style="width:10rem;" alt="">
                        </button>
                        <p class="text-center">Developer</p>
                      </form>
                    </div>
                    <div class="col-lg-6">
                      <form class="user" action="includes/login.inc.php" method="POST">
                        <input type="hidden" name="demousername" value="submitterdemo">
                        <button class="demo-user" type="submit" name="submitter-login-submit">
                          <img src="img/submitter2_profile.svg" class="img-fluid px3 px-sm4 mt-3 mb4" style="width:10rem;" alt="">
                        </button>
                        <p class="text-center">Submitter</p>
                      </form>
                    </div>
                  </div>

                  <hr>
                  <div class="text-center">
                    <a class="small" href="reset-password.php">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="signup.php">Create an Account!</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="index.php">Already have an account? Login!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
