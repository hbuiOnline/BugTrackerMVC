<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Bug Tracker - Sign Up</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="style/style.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <?php
                if(isset($_GET['error'])){ //when we have something equal to something in URL, use _GET method
                    if($_GET['error'] =="emptyfield"){
                        echo '<p class="alert alert-danger mt-3 mx-auto text-center" style="width: 300px" role="alert"> Fill in all fields!</p>';
                    }
                    elseif($_GET['error'] == 'invalidemailuid'){
                        echo '<p class="alert alert-danger mt-3 mx-auto text-center" style="width: 300px" role="alert"> Invalid username and e-mail!</p>';
                    }
                    elseif($_GET['error'] == 'invalidemail'){
                        echo '<p class="alert alert-danger mt-3 mx-auto text-center" style="width: 300px" role="alert"> Invalid e-mail!</p>';
                    }
                    elseif($_GET['error'] == 'invaliduid'){
                        echo '<p class="alert alert-danger mt-3 mx-auto text-center" style="width: 300px" role="alert"> Invalid username!</p>';
                    }
                    elseif($_GET['error'] == 'passwordcheck'){
                        echo '<p class="alert alert-danger mt-3 mx-auto text-center" style="width: 300px" role="alert"> Passwords are not match!</p>';
                    }
                    elseif($_GET['error'] == 'usernameTaken'){
                        echo '<p class="alert alert-danger mt-3 mx-auto text-center" style="width: 300px" role="alert"> Username is already taken!</p>';
                    }
                }
                elseif(isset($_GET['signup'])){
                    if($_GET['signup'] =="success"){
                        echo '<p class="alert alert-success mt-3 mx-auto text-center" style="width: 300px" role="alert"> Signup Successfully!</p>';
                    }

                }
             ?>
              <form class="user" action="includes/signup.inc.php" method="POST">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" name="uidfirst" class="form-control form-control-user" id="exampleFirstName" required placeholder="First Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="uidlast" class="form-control form-control-user" id="exampleLastName" required placeholder="Last Name">
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" name="uid" class="form-control form-control-user" required placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="text" name="mail" class="form-control form-control-user" required placeholder="Email Address">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" name="pwd" class="form-control form-control-user" id="exampleInputPassword" required placeholder="Password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" name="pwd-confirm" class="form-control form-control-user" id="exampleRepeatPassword" required placeholder="Repeat Password">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block" name="signup-submit">Register Account</button>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="reset-password.php">Forgot Password?</a>
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

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
