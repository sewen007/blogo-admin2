<?php
session_start();
require_once 'engine/requires.php'; 

$blog = new blog();
$allPosts = $blog->getAllBlogPosts();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>View All Blog Posts</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="index.html">i-Blogo Admin</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search"></i>
          </button>
      </div>
  </div>
</form>

<!-- Navbar -->
<ul class="navbar-nav ml-auto ml-md-0">
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <span class="badge badge-danger">9+</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
        <a class="dropdown-item" href="#">Action</a>
        <a class="dropdown-item" href="#">Another action</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#">Something else here</a>
    </div>
</li>
<li class="nav-item dropdown no-arrow mx-1">
  <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-envelope fa-fw"></i>
    <span class="badge badge-danger">7</span>
</a>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
    <a class="dropdown-item" href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">Something else here</a>
</div>
</li>
<li class="nav-item dropdown no-arrow">
  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-user-circle fa-fw"></i>
</a>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
    <a class="dropdown-item" href="#">Settings</a>
    <a class="dropdown-item" href="#">Activity Log</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
</div>
</li>
</ul>

</nav>

<div id="wrapper">

  <!-- Sidebar -->
  <ul class="sidebar navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="index.html">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </a>
</li>
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-fw fa-folder"></i>
    <span>Pages</span>
</a>
<div class="dropdown-menu" aria-labelledby="pagesDropdown">
    <h6 class="dropdown-header">Login Screens:</h6>
    <a class="dropdown-item" href="login.html">Login</a>
    <a class="dropdown-item" href="register.html">Register</a>
    <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
    <div class="dropdown-divider"></div>
    <h6 class="dropdown-header">Other Pages:</h6>
    <a class="dropdown-item" href="404.html">404 Page</a>
    <a class="dropdown-item" href="blank.html">Blank Page</a>
</div>
</li>
<li class="nav-item">
  <a class="nav-link" href="charts.html">
    <i class="fas fa-fw fa-chart-area"></i>
    <span>Charts</span></a>
</li>
<li class="nav-item">
  <a class="nav-link" href="tables.html">
    <i class="fas fa-fw fa-table"></i>
    <span>Tables</span></a>
</li>
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-fw fa-folder"></i>
    <span>Blog</span>
</a>
<div class="dropdown-menu" aria-labelledby="pagesDropdown">
    <h6 class="dropdown-header">Blog Elements:</h6>
    <a class="dropdown-item" href="create-post.php">Create new post</a>
    <a class="dropdown-item" href="view-blogposts.php">View blogposts</a>
    <!-- <a class="dropdown-item" href="forgot-password.html">Forgot Password</a> -->
            <!-- <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Other Pages:</h6>
            <a class="dropdown-item" href="404.html">404 Page</a> -->
            <!-- <a class="dropdown-item" href="blank.html">Blank Page</a> -->
        </div>
    </li>
</ul>

<div id="content-wrapper">
 <div class="row">
    <div class="col-lg-12">
        <div class="m-portlet" style="padding: 35px">

            
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Portlet-->
                    <!--begin::Portlet-->
                    <div class="m-portlet">
                        <!--begin::Form-->                            
                        <form action="engine/actions/get-all-blogposts.php" method="POST" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                            <div class="m-portlet__body">   
                                <div class="form-group m-form__group row" style="padding-bottom: 80px; border-bottom: none">
                                    
                                </div>          
                            </div>
                        </form>
                        
                        <div class="m-portlet__body">
                            <!--begin: Search Form -->
                            <div class="row align-items-center">
                                <div class="col-xl-8 order-2 order-xl-1">
                                    <div class="form-group m-form__group row align-items-center">
                                        <div class="col-md-4">
                                            <div class="m-input-icon m-input-icon--left">
                                                <input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
                                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                                    <span><i class="la la-plus"></i></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                    <a href="get-all-blogposts" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>View More Posts</span>
                                        </span>
                                    </a>                    
                                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                                </div>
                            </div>
                            <!--end: Search Form -->

                            <?php include 'widgets/view-posts.php'; ?>
                        </div>
                        

                        <!--end::Form-->
                    </div>
                    <!--end::Portlet-->

                    <!--begin::modal-->
                    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Entry</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>You are about to delete this post. <br><br>
                                        This action would be permanent and you won't be able to retrieve details of this entry. <br><br>
                                    Are you sure you want to delete it?</p>
                                </div>
                                <div class="modal-footer">
                                    <form method="POST" action="engine/actions/delete-blog-post.php">
                                        <input class="delete-form-payment-id" type="hidden" name="blog-id" value=""/>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Delete Entry</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::modal-->
                </div>
            </div>  
        </div>
    </div>
</div>

<!-- /.container-fluid -->

<!-- Sticky Footer -->
<footer class="sticky-footer">
  <div class="container my-auto">
    <div class="copyright text-center my-auto">
      <span>Copyright © i-Blogo.com 2018</span>
  </div>
</div>
</footer>

</div>
<!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

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
    <a class="btn btn-primary" href="login.html">Logout</a>
</div>
</div>
</div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="vendor/chart.js/Chart.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin.min.js"></script>

<!-- Demo scripts for this page-->
<script src="js/demo/datatables-demo.js"></script>
<script src="js/demo/chart-area-demo.js"></script>
<script type="text/javascript" src="js/ckeditor2/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="jquery/jquery.js"></script>

</body>

</html>
