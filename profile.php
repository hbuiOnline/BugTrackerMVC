<?php
  session_start();
  include 'includes/autoloader.inc.php';
  $projectObj = new ProjectsView();
  $userObj = new UsersView();
  $ticketObj = new TicketsView();

 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Bug Tracker - Profile</title>

  <!-- Custom fonts for this template -->
  <link rel="stylesheet" type="text/css" href="style/style.css">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php
      include 'sidebar.php';
     ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include 'topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Profile Details</h1>
          <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#profileEditModal">
            <span class="icon text-white-50">
              <i class="fas fa-user-cog"></i>
            </span>
            <span class="text">Edit Profile</span>
          </a>
          <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#pwdEditModal">
            <span class="icon text-white-50">
              <i class="fas fa-lock"></i>
            </span>
            <span class="text">Change Password</span>
          </a>
          <?php
              if (isset($_GET['error'])) {
                if ($_GET['error'] == 'emptyfield') {
                  echo '<p class="alert alert-danger mt-3 mx-auto text-center" style="width: 300px" role="alert">Please fill in all field.</p>';
                }
                elseif ($_GET['error'] == 'notcurrentpwd') {
                  echo '<p class="alert alert-danger mt-3 mx-auto text-center" style="width: 300px" role="alert">The current password is incorrect.</p>';
                }
                elseif ($_GET['error'] == 'newpwdnotmatch') {
                  echo '<p class="alert alert-danger mt-3 mx-auto text-center" style="width: 300px" role="alert">The new passwords are not match.</p>';
                }
              }

              elseif (isset($_GET['newpwdset'])) {
                if ($_GET['newpwdset'] == 'success') {
                  // echo '<a href="login.php"><b>Home</b></a>';
                  echo '<p class="alert alert-success mt-3 mx-auto text-center" style="width: 300px" role="alert">Your password has been changed.</p>';
                }
              }

           ?>
          <hr class="divider">

          <!-- Content Row -->

          <div class="row">
            <div class="col-lg-6">
                <img src="img/undraw_profile.svg" class="img-fluid px3 px-sm4 mt-3 mb4" style="width:46rem;" alt="">
            </div>
            <div class="col-lg-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">

                  <h6 class="m-0 font-weight-bold text-primary text-lg"><i class="far fa-user"></i> Profile</h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-4">
                      <p class="text-gray-500">First Name</p>
                      <p class="text-gray-900 text-lg projectdetail">
                      <strong>
                        <?php
                        $userArrayDetail = $userObj->usersDetailShow($_SESSION['userID']);
                        echo $userArrayDetail['userfirst'];
                        ?>
                      </strong>
                    </div>
                    <div class="col-lg-4">
                      <p class="text-gray-500">Last Name</p>
                      <p class="text-gray-900 text-lg projectdetail">
                      <strong>
                        <?php echo $userArrayDetail['userlast']; ?>
                      </strong>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-4">
                      <p class="text-gray-500">User ID</p>
                      <p class="text-gray-900 text-lg projectdetail">
                      <strong>
                        <?php echo $userArrayDetail['userid']; ?>
                      </strong>
                    </div>
                    <div class="col-lg-4">
                      <p class="text-gray-500">User Role</p>
                      <p class="text-gray-900 text-lg projectdetail">
                      <strong>
                        <?php echo $userArrayDetail['userrole']; ?>
                      </strong>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <p class="text-gray-500">User Email</p>
                      <p class="text-gray-900 text-lg projectdetail">
                      <strong>
                        <?php echo $userArrayDetail['useremail']; ?>
                      </strong>
                    </div>

                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span> Copyright &copy; <script>document.write(new Date().getFullYear());</script> Bug Tracker MVC. All rights reserved.</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Project Update Modal-->
  <div class="modal fade" id="profileEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change Profile Info</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <form class="user" action="includes/profilemanager.inc.php" method="POST">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <input type="hidden" name="uid" value="<?php echo $_SESSION['userID']; ?>">
                <input type="text" class="form-control ticket-mordal" name="userfirst" value="<?php echo $userArrayDetail['userfirst']; ?>">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <input type="text" class="form-control ticket-mordal" name="userlast" value="<?php echo $userArrayDetail['userlast']; ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <input type="text" class="form-control ticket-mordal" name="useremail" size="30" value="<?php echo $userArrayDetail['useremail']; ?>">
              </div>
            </div>
          </div>
          <button class="btn btn-primary btn-mordal" type="submit" name="profile-update">Update</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Password Update Modal -->
  <div class="modal fade" id="pwdEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <form class="user" action="includes/profilemanager.inc.php" method="POST">
          <div class="form-group">
            <input type="hidden" name="uid" value="<?php echo $_SESSION['userID']; ?>">
            <input type="password" class="form-control ticket-mordal" name="current-pwd" required placeholder="Current Password">
          </div>
          <div class="form-group">
            <input type="password" class="form-control ticket-mordal" name="new-pwd" required placeholder="New Password">
          </div>
          <div class="form-group">
            <input type="password" class="form-control ticket-mordal" name="confirm-new-pwd" required placeholder="Confirm Password">
          </div>
          <button class="btn btn-primary btn-mordal" type="submit" name="pwd-update">Change</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="includes/logout.inc.php">Logout</a>
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

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="style/datatables.js"></script>


</body>

</html>
