<!DOCTYPE html>
<?php
require_once './config/session_info.php';
require_once './config/DBAdapter.php';
include_once 'config.php';
$dba = new DBAdapter();
//get data for edit
if (isset($_GET['id'])) {
    $data = $dba->getRowAssoc("main_category", array("*"), "id=" . $_GET['id']);
    $image = count($data[0]['main_image']);
}
?>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Main-Category</title>

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
                            <a href="">Main Category</a>
                        </li>

                    </ol>

                    <!-- Icon Cards-->
                    <div class="row">
                        <div class="col-xl-10">
                            <form action="maincategory.php" method="post" enctype="multipart/form-data">

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Category Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control select2" id = "cname" name = "main_cat_name" value="<?= (isset($_GET['id'])) ? $data[0]['main_cat_name'] : '' ?>" placeholder = "Category Name" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input form-control" name="main_image"  value="">
                                            <label class="custom-file-label"  for="customFile"><?= (isset($_GET['id'])) ? $data[0]['main_image'] : 'Choose File' ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">  
                                    <div class="col-sm-2"> </div>
                                    <div class="col-sm-10">
                                        <?= (isset($_GET['id'])) ? '<input type="hidden" name="id" value="' . $_GET['id'] . '">' : '' ?>
                                        <input type="hidden" name="action" id='action' value="<?= (isset($_GET['id'])) ? 'edit' : 'add' ?>">
                                        <button  type="submit" id='submit-button' class="btn btn-primary btn-block w-md waves-effect waves-light">Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table"></i>&nbsp;Main Category</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
										$PathToFile ='Main-Category';
                                        include_once './config/DBAdapter.php';
                                        $dba = new DBAdapter();
                                        $data = $dba->getRowAssoc("main_category", array("*"), "1");
                                        $i = 1;
                                        if (!empty($data)) {
                                            foreach ($data as $row) {
                                                echo "<tr>";
                                                echo "<td>" . $i . "</td>";
                                                echo "<td>" . $row['main_cat_name'] . "</td>";
												
												if (is_file($PathToFile . '/'.$row['main_image'].'')){
                                                    $FileDetails = stat($PathToFile . '/'.$row['main_image'].'');
                                                    echo '<td><img src="Main-Category/'.$row['main_image'].'?MT=' . dechex($FileDetails['mtime']) . '" style="width:50px; height:50px;"/></td>';
                                                }else{
													echo "<td><img src='Main-Category/" . $row['main_image'] . "' alt='image' style='width:50px; height:50px;'></td>";
												}
											
                                                echo "<td><a href='main_category.php?id=" . $row['id'] . "' class='btn btn-primary waves-effect waves-light'>Edit</a>&nbsp<a href='delete.php?mid=" . $row['id'] . "' class='btn btn-primary waves-effect waves-light'>Delete</a></td>";
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

        <!-- Page level plugin JavaScript-->

        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>

        <!-- Demo scripts for this page-->
        <script src="js/demo/datatables-demo.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <script src="js/sb-basic.js"></script>
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

    </body>
</html>
