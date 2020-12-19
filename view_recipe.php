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

        <title>View Recipe</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Page level plugin CSS-->
        <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
        <link href="vendor/datatables/buttons.bootstrap4.min.css" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">
        <link href="css/bootstrap3-wysihtml5.min.css" rel="stylesheet">
        <link href="js/select2/css/select2.min.css" rel="stylesheet">

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
                            <a href="">View Recipe</a>
                        </li>

                    </ol>

                    <!-- Icon Cards-->
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table"></i>&nbsp;View Recipe</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>

                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Details</th>
                                            <!--<th>Ingrediants</th>-->
                                            <th>Video URL</th>
                                            <th>Author Name</th>
                                            <th>Duration</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        include_once './config/DBAdapter.php';
                                        $dba = new DBAdapter();
                                        $data = $dba->getRowAssoc("`add_recipe` INNER JOIN main_category ON add_recipe.category_id=main_category.id", array("add_recipe.*,main_category.main_cat_name"), "1");
                                        $i = 1;
                                        if (!empty($data)) {
                                            foreach ($data as $row) {
                                                echo "<tr>";
                                                echo "<td>" . $i . "</td>";
                                                echo "<td>" . $row['name'] . "</td>";
                                                echo "<td><img src='Recipt/" . $row['image'] . "' alt='image' style='width:50px; height:50px;'></td>";
                                                echo "<td>" . $row['main_cat_name'] . "</td>";
//                                                echo "<td>" . htmlspecialchars_decode($row['details']) . "</td>";
                                                echo "<td>" . $row['details'] . "</td>";
                                                echo "<td>" . $row['video_url'] . "</td>";
                                                echo "<td>" . $row['author_name'] . "</td>";
                                                echo "<td>" . $row['duration'] . "</td>";
                                                echo "<td><a href='add_recipe.php?id=" . $row['id'] . "' class='btn btn-primary waves-effect waves-light'>Edit</a>&nbsp<a href='delete.php?recid=" . $row['id'] . "' class='btn btn-primary waves-effect waves-light'>Delete</a></td>";
                                                echo "</tr>";
                                                $i++;
                                            }
                                        }
                                        ?>   
                                    </tbody>
                                </table>
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

        <!-- Required datatable js -->
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="vendor/datatables/dataTables.buttons.min.js"></script>
        <script src="vendor/datatables/buttons.bootstrap4.min.js"></script>
        <script src="vendor/datatables/jszip.min.js"></script>
        <script src="vendor/datatables/pdfmake.min.js"></script>
        <script src="vendor/datatables/vfs_fonts.js"></script>
        <script src="vendor/datatables/buttons.html5.min.js"></script>
        <script src="vendor/datatables/buttons.print.min.js"></script>
        <script src="vendor/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="vendor/datatables/dataTables.responsive.min.js"></script>
        <script src="vendor/datatables/responsive.bootstrap4.min.js"></script>

        <script src="js/datatables.init.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>

        <!-- Demo scripts for this page-->
        <script src="js/demo/datatables-demo.js"></script>
        <script src="js/select2/select2.min.js"></script>

    </body>

</html>
