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

  <title>Bug Tracker - Ticket Details</title>

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
          <h1 class="h3 mb-2 text-gray-800">Ticket Details</h1>
          <?php
            if ($_SESSION['userID'] & $rbac->Users->hasRole('admin', $_SESSION['userID'])) {
              ?>
              <a href="projects.php" class="btn btn-secondary btn-icon-split btn-sm">
                <span class="icon text-white-50">
                  <i class="far fa-list-alt"></i>
                </span>
                <span class="text">Project List</span>
              </a>
              <?php
            }

           ?>

          <a href="tickets.php" class="btn btn-secondary btn-icon-split btn-sm">
            <span class="icon text-white-50">
              <i class="fas fa-list-ul"></i>
            </span>
            <span class="text">Ticket List</span>
          </a>
          <hr class="divider">

          <!-- Content Row -->
          <div class="row">
            <div class="col-lg-6"> <!-- Ending Ticket Details Card-->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary text-lg">Details for Ticket #<?php echo $_GET['tid']; ?></h6>

                  <!-- Edit tickets is only available for project manager and admin -->
                  <?php
                    if ($_SESSION['userID'] && ($rbac->Users->hasRole('admin', $_SESSION['userID']) || $rbac->Users->hasRole('project-manager', $_SESSION['userID']))) {
                      ?>
                      <a href="#" class="btn btn-primary btn-icon-split btn-sm prjbtnedit" data-toggle="modal" data-target="#ticketEditModal">
                        <span class="icon text-white-50">
                          <i class="fas fa-cogs"></i>
                        </span>
                        <span class="text">Edit Ticket</span>
                      </a>
                      <?php
                    }
                   ?>

                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                        <p class="text-gray-500">Name:</p>
                        <p class="text-gray-900 projectdetail">
                          <?php
                            $ticketArrayDetail = $ticketObj->ticketDetailShow($_GET['tid']);
                            echo $ticketArrayDetail['title'];
                          ?>
                       </p>

                    </div>
                    <div class="col-lg-6">
                        <p class="text-gray-500">Description:</p>
                        <p class="text-gray-900 projectdetail">
                          <?php
                            echo $ticketArrayDetail['description'];
                          ?>
                       </p>

                    </div>
                  </div>
                   <hr> <!--Divider -->
                  <div class="row">
                    <div class="col-lg-6">
                      <p class="text-gray-500">Assigned Developer</p>
                      <p class="text-gray-900 projectdetail">
                        <?php
                          echo $ticketArrayDetail['ticketDevName'];
                         ?>
                      </p>
                    </div>
                    <div class="col-lg-6">
                      <p class="text-gray-500">Submitter</p>
                      <p class="text-gray-900 projectdetail">
                        <?php
                          echo $ticketArrayDetail['ticketSubmitter'];
                        ?>
                      </p>
                    </div>
                  </div>
                  <hr> <!--Divider -->
                  <div class="row">
                    <div class="col-lg-6">
                      <p class="text-gray-500">Project</p>
                      <p class="text-gray-900 projectdetail">
                        <?php
                          echo $ticketArrayDetail['ticketProject'];
                         ?>
                      </p>
                    </div>
                    <div class="col-lg-6">
                      <p class="text-gray-500">Ticket Priority</p>
                      <p class="text-gray-900 projectdetail">
                        <?php
                          echo $ticketArrayDetail['ticketPriority'];
                         ?>
                      </p>
                    </div>
                  </div>
                  <hr> <!--Divider -->
                  <div class="row">
                    <div class="col-lg-6">
                      <p class="text-gray-500">Ticket Status</p>
                      <p class="text-gray-900 projectdetail">
                        <?php
                          echo $ticketArrayDetail['ticketStatus'];
                         ?>
                      </p>
                    </div>
                    <div class="col-lg-6">
                      <p class="text-gray-500">Ticket Type</p>
                      <p class="text-gray-900 projectdetail">
                        <?php
                          echo $ticketArrayDetail['ticketType'];
                         ?>
                      </p>
                    </div>
                  </div>
                  <hr> <!--Divider -->
                  <div class="row">
                    <div class="col-lg-6">
                      <p class="text-gray-500">Created</p>
                      <p class="text-gray-900 projectdetail">
                        <?php
                          echo $ticketArrayDetail['ticketCreated'];
                         ?>
                      </p>
                    </div>
                    <div class="col-lg-6">
                      <p class="text-gray-500">Updated</p>
                      <p class="text-gray-900 projectdetail">
                        <?php
                          echo $ticketArrayDetail['ticketUpdate'];
                         ?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- Ending Ticket Details Card-->

            <div class="col-lg-6">
              <h5>Add a Comment?</h5>
              <?php
                if (isset($_GET['error'])) {
                  if ($_GET['error'] == 'emptyfield') {
                    ?>
                      <p class="alert alert-danger mt-3 mb-0 mx-auto text-center" style="width: 300px" role="alert">Comment is empty!</p><br>
                    <?php
                  }
                }
               ?>
              <form action="includes/ticketsubmit.inc.php" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="POST">
                <div class="input-group">
                  <input type="hidden" name="tid" value="<?php echo $_GET['tid']; ?>">
                  <input name="ticketmessage" type="text" class="form-control border-left-primary small" size="67" placeholder="Adding Comment..." aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" name="ticket-comment">
                      <i class="fas fa-comments"></i>
                    </button>
                  </div>
                </div>

              </form>
              <div class="card shadow mb-4 card-cm-head"> <!-- Ticket for Ticket Comment Card-->
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary text-lg">Ticket Comment</h6>
                  <p class="p-sub">All Comment for this Ticket</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered display" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Commenter</th>
                          <th>Message</th>
                          <th>Created</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          echo $ticketObj->ticketCommentDataShow($_GET['tid']);
                         ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div> <!-- End of ticket Comment Card -->
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <div class="card shadow mb-4"><!-- Ticket History Card-->
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary text-lg">Ticket History</h6>
                  <p class="p-sub">All History Information for this Ticket</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered display" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Old Value</th>
                          <th>New Value</th>
                          <th>Date Changed</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          echo $ticketObj->ticketHistoryDataShow($_GET['tid']);
                         ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div><!-- Ending Ticket History Card-->
            </div>

            <div class="col-lg-6">
              <h5>Add an Attachment?</h5>
              <div class="card shadow mb-4"><!-- Ticket for project Card-->
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary text-lg">Ticket Attachments</h6>
                </div>
                <div class="card-body">

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

  <!-- Ticket Edit Modal -->
  <div class="modal fade" id="ticketEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change Ticket Properties</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <form class="user" action="includes/ticketsubmit.inc.php" method="POST">

          <div class="form-group">
            <input type="hidden" name="tid" value="<?php echo $_GET['tid']; ?>">
            <input type="text" class="form-control ticket-mordal" name="tickettitle" value="<?php echo $ticketArrayDetail['title']; ?>">
          </div>
          <div class="form-group">
            <input type="text" class="form-control ticket-mordal" name="ticketdescription" value="<?php echo $ticketArrayDetail['description']; ?>">
          </div>

          <div class="row">
            <div class="col-lg-6">
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
            <div class="col-lg-6">
              <label class="optionlist ticketedit" id="dropdown-options" for="projectname">
                <svg class="bi bi-card-heading" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                 <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 00-.5.5v9a.5.5 0 00.5.5h13a.5.5 0 00.5-.5v-9a.5.5 0 00-.5-.5zm-13-1A1.5 1.5 0 000 3.5v9A1.5 1.5 0 001.5 14h13a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0014.5 2h-13z" clip-rule="evenodd"/>
                 <path fill-rule="evenodd" d="M3 8.5a.5.5 0 01.5-.5h9a.5.5 0 010 1h-9a.5.5 0 01-.5-.5zm0 2a.5.5 0 01.5-.5h6a.5.5 0 010 1h-6a.5.5 0 01-.5-.5z" clip-rule="evenodd"/>
                 <path d="M3 5.5a.5.5 0 01.5-.5h9a.5.5 0 01.5.5v1a.5.5 0 01-.5.5h-9a.5.5 0 01-.5-.5v-1z"/>
               </svg>
                Project Name: </label>
              <select class="form-control ticket-option" name="projectid">
                <?php
                   echo $projectObj->projectDataOptionsInput();
                 ?>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6">
              <label class="optionlist ticketedit" id="dropdown-options" for="ticketpriority">
                <svg class="bi bi-exclamation-diamond-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                 <path fill-rule="evenodd" d="M9.05.435c-.58-.58-1.52-.58-2.1 0L.436 6.95c-.58.58-.58 1.519 0 2.098l6.516 6.516c.58.58 1.519.58 2.098 0l6.516-6.516c.58-.58.58-1.519 0-2.098L9.05.435zM8 4a.905.905 0 00-.9.995l.35 3.507a.552.552 0 001.1 0l.35-3.507A.905.905 0 008 4zm.002 6a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
               </svg>
                Ticket Priority: </label>
              <select class="form-control ticket-option" name="ticketpriority">
                <option value="Urgent">Urgent</option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
                <option value="None">None</option>
              </select>
            </div>
            <div class="col-lg-6">
              <label class="optionlist ticketedit" id="dropdown-options" for="ticketstatus">
                <svg class="bi bi-app-indicator" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M5.5 2A3.5 3.5 0 002 5.5v5A3.5 3.5 0 005.5 14h5a3.5 3.5 0 003.5-3.5V8a.5.5 0 011 0v2.5a4.5 4.5 0 01-4.5 4.5h-5A4.5 4.5 0 011 10.5v-5A4.5 4.5 0 015.5 1H8a.5.5 0 010 1H5.5z" clip-rule="evenodd"/>
                  <path d="M16 3a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Ticket Status: </label>
              <select class="form-control ticket-option" name="ticketstatus">
                <option value="Open">Open</option>
                <option value="Closed">Closed</option>
                <option value="Resolved">Resolved</option>
                <option value="Pending">Pending</option>
              </select>
            </div>
          </div>
          <div class="row">
              <div class="col-lg-6">
                <label class="optionlist ticketedit" id="dropdown-options" for="tickettype">
                   <svg class="bi bi-info-circle-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 16A8 8 0 108 0a8 8 0 000 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                  </svg>
                   Ticket Type: </label>
                 <select class="form-control ticket-option" id="tickettype" name="tickettype">
                   <option value="Bugs/Errors">Bugs/Errors</option>
                   <option value="Feature Request">Feature Request</option>
                   <option value="Training/Documents">Training/Documents</option>
                   <option value="Testing Application">Testing Application</option>
                   <option value="Other Comments">Other Comments</option>
                 </select>
              </div>
          </div>
          <button class="btn btn-primary btn-mordal" type="submit" name="ticket-update">Update</button>
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
