<!DOCTYPE html>
<?php
require_once './config/session_info.php';
require_once './config/DBAdapter.php';
include_once 'config.php';
$dba = new DBAdapter();
?>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Dashboard</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Page level plugin CSS-->
        <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">

    </head>

    <body id="page-top">

        <?php require_once './topbar.php'; ?>

        <div id="wrapper">

            <!-- Sidebar -->
            <?php require_once './sidebar.php'; ?>

            <div id="content-wrapper">

                <div class="container-fluid">

                    <!-- Breadcrumbs-->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Dashboard</a>
                        </li>

                    </ol>
					<div class="row">
                        <div class="col-xl-4 col-sm-6 mb-3">
                            <div class="card  bg-primary o-hidden h-100">
                                <div class="card-body">
                                    <?php
                                    $data = $dba->getRowAssoc("main_category", array('count(id) as total'), "1");
                                    ?>
                                    <div class="mr-5">
                                        <button><?= $data[0]['total'] ?></button> Main Category
                                    </div>
                                </div>
                                <a class="card-footer clearfix small z-1" href="main_category.php">
                                    <span class="float-left"></span>
                                    <span class="float-right">
                                        <i class='fa fa-eye'></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                       
                        <div class="col-xl-4 col-sm-6 mb-3">
                            <div class="card bg-success o-hidden h-100">
                                <div class="card-body">
                                    <?php
                                    $data = $dba->getRowAssoc("add_recipe", array('count(id) as total'), "1");
                                    ?>
                                    <div class="mr-5"><button><?= $data[0]['total'] ?></button> Recipe</div>
                                </div>
                                <div class="card-footer  clearfix small z-1">
                                    <a href="view_recipe.php" class="float-right">&nbsp;&nbsp;&nbsp;<i class='fa fa-eye'></i></a><a href="add_recipe.php" class="float-right"><i class='fa fa-plus'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
                <!-- Sticky Footer -->
                <?php require_once './footer.php'; ?>

            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /#wrapper -->





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

    </body>

</html>
