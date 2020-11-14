<?php
  require 'vendor/autoload.php';
  use PhpRbac\Rbac;
  $rbac = new Rbac();

 ?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <?php
    if ($rbac->Users->hasRole('admin', $_SESSION['userID'])) {
      ?> <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php"> <?php
    }
    else {
      ?> <a class="sidebar-brand d-flex align-items-center justify-content-center" href="tickets.php"> <?php
    }
   ?>
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-bug"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Bug Tracker</div> <!-- <sup>2</sup> -->
  </a>



  <?php
    if ($_SESSION['userID']) { //Only admin has this management
      if ($rbac->Users->hasRole('admin', $_SESSION['userID'])) {
        ?>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
          <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
          Management
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link" href="users.php">
            <i class="fas fa-users"></i>
            <span>Users</span>
          </a>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link" href="rolepermission.php">
            <i class="fas fa-user-tag"></i>
            <span>Roles & Permissions</span>
          </a>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link" href="projects.php">
            <i class="fas fa-project-diagram"></i>
            <span>Projects</span>
          </a>
        </li>
        <?php
      }
      elseif ($rbac->Users->hasRole('project-manager', $_SESSION['userID'])) {
        ?>
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link" href="projects.php">
            <i class="fas fa-project-diagram"></i>
            <span>Projects</span>
          </a>
        </li>
        <?php
      }
      ?>

      <?php
    }
   ?>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Tickets
  </div>

  <!-- Nav Item - Tables -->
  <li class="nav-item">
    <a class="nav-link" href="tickets.php">
      <i class="fas fa-ticket-alt"></i>
      <span>Tickets</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
