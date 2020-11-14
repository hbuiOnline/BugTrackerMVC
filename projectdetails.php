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

  <title>Bug Tracker - Project Details</title>

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
          <h1 class="h3 mb-2 text-gray-800">Project Details</h1>
          <a href="projects.php" class="btn btn-secondary btn-icon-split btn-sm">
            <span class="icon text-white-50">
              <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Project List</span>
          </a>
          <hr class="divider">

          <!-- Content Row -->
          <div class="row">
            <div class="col-lg-12"> <!-- Project Name & Description Card-->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary text-lg">Details for Project #<?php echo $_GET['pid']; ?></h6>
                  <a href="#" class="btn btn-primary btn-icon-split btn-sm prjbtnedit" data-toggle="modal" data-target="#projectEditModal">
                    <span class="icon text-white-50">
                      <i class="fas fa-cogs"></i>
                    </span>
                    <span class="text">Edit Project</span>
                  </a>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                        <p class="text-gray-500">Name:</p>
                        <p class="text-gray-900 text-lg projectdetail">
                          <strong>
                            <?php
                              $projectArrayDetail = $projectObj->projectDetailShow($_GET['pid']);
                              echo $projectArrayDetail['name'];
                            ?>
                          </strong>
                       </p>
                    </div>
                    <div class="col-lg-6">
                        <p class="text-gray-500">Description:</p>
                        <p class="text-gray-900 text-lg projectdetail">
                          <strong>
                            <?php
                              echo $projectArrayDetail['description'];
                            ?>
                          </strong>
                       </p>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- Ending Project Name & Description Card-->
          </div>

          <div class="row">
            <div class="col-lg-7">
              <div class="card shadow mb-4"><!-- Assigned Personnel Card-->
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary text-lg">Ticket For This Project</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered display" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Submitter</th>
                          <th>Developer</th>
                          <th>Status</th>
                          <th>Created</th>
                          <th>Details</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          echo $ticketObj->ticketDataInProjectShow($_GET['pid']);
                         ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div><!-- Ending Assigned Personnel Card-->
            </div>
            <div class="col-lg-5">
              <div class="card shadow mb-4"><!-- Ticket for project Card-->
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary text-lg">Assigned Personnel</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered display" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>User Name</th>
                          <th>Email</th>
                          <th>Role</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          echo $projectObj->projectAssignedPersonnelShow($_GET['pid']);
                         ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div><!-- Ending Ticket for project Card-->
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

  <!-- Profile Update -->
  <div class="modal fade" id="projectEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change Ticket Properties</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <form class="user" action="includes/projectmanager.inc.php" method="POST">

          <div class="form-group">
            <input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>">
            <input type="text" class="form-control ticket-mordal" name="projecttitle" value="<?php echo $projectArrayDetail['name']; ?>">
          </div>
          <div class="form-group">
            <input type="text" class="form-control ticket-mordal" name="projectdescription" value="<?php echo $projectArrayDetail['description']; ?>">
          </div>

          <div class="row">
              <label class="optionlist ticketedit" id="dropdown-options" for="assignto">
                <svg class="bi bi-card-heading" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                 <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 00-.5.5v9a.5.5 0 00.5.5h13a.5.5 0 00.5-.5v-9a.5.5 0 00-.5-.5zm-13-1A1.5 1.5 0 000 3.5v9A1.5 1.5 0 001.5 14h13a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0014.5 2h-13z" clip-rule="evenodd"/>
                 <path fill-rule="evenodd" d="M3 8.5a.5.5 0 01.5-.5h9a.5.5 0 010 1h-9a.5.5 0 01-.5-.5zm0 2a.5.5 0 01.5-.5h6a.5.5 0 010 1h-6a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>
                 <path d="M3 5.5a.5.5 0 01.5-.5h9a.5.5 0 01.5.5v1a.5.5 0 01-.5.5h-9a.5.5 0 01-.5-.5v-1z"/>
               </svg>
                Assign Developer </label>
              <select class="form-control ticket-option" name="assignto">
                <option value="NULL">---</option>
                <?php
                   echo $userObj->usersNameShow();
                 ?>
              </select>


          </div>

          <button class="btn btn-primary btn-mordal" type="submit" name="project-update">Update</button>
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
