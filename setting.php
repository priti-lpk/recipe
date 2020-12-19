<!DOCTYPE html>
<?php
require_once './config/session_info.php';
require_once './config/DBAdapter.php';
include_once 'config.php';
$dba = new DBAdapter();
//get data for edit
$data = $dba->getRowAssoc("setting", array("*"), "1");
?>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Setting</title>

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
                            <a href="">Setting</a>
                        </li>

                    </ol>

                    <!-- Icon Cards-->
                    <div class="row">
                        <div class="col-xl-10">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label">Notification Status</label>
                                    <div class="col-sm-4">
                                        <label class="switch">
                                            <?php
                                            include_once './config/DBAdapter.php';
                                            $dba = new DBAdapter();
                                            $data = $dba->getRowAssoc("notification", array("*"), "1");
                                            if ($data[0]['status'] == 'true') {
                                                echo "<input type='checkbox' name='status' switch='none' data-status='false'  id=" . $data[0]['id'] . " onclick='changeStatus(this.id);' checked><span class='slider round'></span>";
                                            } else {
                                                echo "<input type='checkbox' name='status' switch='none' data-status='true'  id=" . $data[0]['id'] . " onclick='changeStatus(this.id);' ><span class='slider round'></span>";
                                            }
                                            ?>
                                        </label>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    
                    <hr>



                </div>
                <!-- /.container-fluid -->

                <!-- Sticky Footer -->
                <?php require_once './footer.php'; ?>

            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <script>
            function changeStatus(cid) {

                $.ajax({
                    url: "SRFilter.php",
                    type: "POST",
                    data: {
                        cid: cid,
                        status: $("#" + cid).data('status'),
                        action: "changeStatus"
                    },
                    dataType: "json",
                    success: function (data) {
                        // alert(jsonData);
                        if (data.status) {
                            alert("sucess");
                            window.location.reload();
                        } else {
                            alert("fail");
                        }
                    },
                    fail: function () {
                        swal("Error!", "Error while performing operation!", "error");
                    },
                    error: function (data, status, jg) {
                        swal("Error!", data.responseText, "error");
                    }
                });
            }
        </script>
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
