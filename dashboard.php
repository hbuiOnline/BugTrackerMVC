<?php
  session_start();
  include 'includes/autoloader.inc.php';
  $ticketObj = new TicketsView();
  $ticketStatusArrayCount = $ticketObj->ticketStatusCountShow();
  $ticketPriorityArray = $ticketObj->ticketPriorityCountShow();
  $ticketTypeArray = $ticketObj->ticketTypeCountShow();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Bug Tracker - Logged In</title>
  <link rel="shortcut icon" type="image/x-icon" href="img/bugLogo.png" />


  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="style/override2.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>
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
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <form action="includes/report.inc.php" method="POST">
              <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" type="submit" name="report-request">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
              </button>
            </form>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <a href="tickets.php?status=open">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">OPEN TICKETS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ticketStatusArrayCount['ticketopen']; ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </a>

              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <a href="tickets.php?status=pending">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">PENDING TICKETS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ticketStatusArrayCount['ticketpending']; ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-spinner fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <a href="tickets.php?status=resolved">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">RESOLVED TICKETS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ticketStatusArrayCount['ticketresolved']; ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-check fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <a href="tickets.php?status=closed">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">CLOSED TICKETS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ticketStatusArrayCount['ticketclosed']; ?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>



          </div>

          <!-- Content Row -->

          <div class="row">

            <!-- Bar Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Ticket By Priority</h6>
                </div>
                <div class="card-body">
                  <div class="chart-bar">
                    <canvas id="myBarChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Ticket by Status</h6>
                  <!-- <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div> -->
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Open
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Pending
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-secondary"></i> Resolved
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Closed
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

              <!-- Project Card Example -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Ticket by Type</h6>
                </div>
                <div class="card-body">
                   <!-- labels: ["Bugs/Errors", "Feature Request", "Training/Documents", "Testing Application", "Other Comments"], -->
                  <h4 class="small font-weight-bold">Bugs/Errors<span class="float-right"> <?php echo $ticketTypeArray['bugratio']; ?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $ticketTypeArray['bugratio']; ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">Feature Request<span class="float-right"><?php echo $ticketTypeArray['featureratio']; ?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $ticketTypeArray['featureratio']; ?>%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">Training/Documents<span class="float-right"><?php echo $ticketTypeArray['testingratio']; ?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: <?php echo $ticketTypeArray['testingratio']; ?>%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">Testing Application<span class="float-right"><?php echo $ticketTypeArray['trainingratio']; ?>%</span></h4>
                  <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $ticketTypeArray['trainingratio']; ?>%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                  <h4 class="small font-weight-bold">Other Comments<span class="float-right"><?php echo $ticketTypeArray['otherratio']; ?>%</span></h4>
                  <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $ticketTypeArray['otherratio']; ?>%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>


            </div>

            <!-- Color System -->
            <!-- <div class="col-lg-6 mb-4">
              <div class="row">
                <div class="col-lg-6 mb-4">
                  <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                      Primary
                      <div class="text-white-50 small">#4e73df</div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-success text-white shadow">
                    <div class="card-body">
                      Success
                      <div class="text-white-50 small">#1cc88a</div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-info text-white shadow">
                    <div class="card-body">
                      Info
                      <div class="text-white-50 small">#36b9cc</div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                      Warning
                      <div class="text-white-50 small">#f6c23e</div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                      Danger
                      <div class="text-white-50 small">#e74a3b</div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-secondary text-white shadow">
                    <div class="card-body">
                      Secondary
                      <div class="text-white-50 small">#858796</div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
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
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script type="text/javascript">
  //TicketStatusCount (Pie Chart)
  var openTicketCount = "<?= $ticketStatusArrayCount['ticketopen']?>";
  var pendingTicketCount = "<?= $ticketStatusArrayCount['ticketpending'] ?>";
  var resolvedTicketCount = "<?= $ticketStatusArrayCount['ticketresolved']?>";
  var closedTicketCount = "<?= $ticketStatusArrayCount['ticketclosed'] ?>";
  </script>
  <script src="style/chart-pie3.js"></script>

  <script type="text/javascript">
  var bugErrorCount = "<?= $ticketTypeArray['bugerror']?>";
  var featureRequestCount = "<?= $ticketTypeArray['featurereq'] ?>";
  var testingCount = "<?= $ticketTypeArray['testing']?>";
  var trainingCount = "<?= $ticketTypeArray['training'] ?>";
  var othersCount = "<?= $ticketTypeArray['others'] ?>";


  var urgentCount = "<?= $ticketPriorityArray['ticketurgent']?>";
  var highCount = "<?= $ticketPriorityArray['tickethigh']?>";
  var mediumCount = "<?= $ticketPriorityArray['ticketmedium']?>";
  var lowCount = "<?= $ticketPriorityArray['ticketlow']?>";
  var noneCount = "<?= $ticketPriorityArray['ticketnone']?>";


  </script>
  <script src="style/priority-chart-bar.js"></script>


</body>

</html>
