<!DOCTYPE html>
<?php
require_once './config/session_info.php';
require_once './config/DBAdapter.php';
include_once 'config.php';

$dba = new DBAdapter();
//get data for edit

if (isset($_GET['id'])) {
    $data = $dba->getRowAssoc("add_item", array("*"), "id=" . $_GET['id']);
    $image = explode(',', $data[0]['image']);
    $img = count($image);
}
?>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Add Item</title>

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
                            <a href="#">Add Item</a>
                        </li>

                    </ol>

                    <!-- Icon Cards-->
                    <div class="row">
                        <div class="col-xl-10">
                            <form action="addItempro.php" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Main Category</label>
                                    <div class="col-sm-10">
                                        <select type="text" class="form-control select2" id = "category" name = "main_category" required="" onchange="Filter(this);">
                                            <option>Select Category</option>       
                                            <?php
                                            include_once './config/DBAdapter.php';
                                            $project = $dba->getRowAssoc("main_category", array("*"), "1");
                                            foreach ($project as $val) {
                                                if (isset($_GET['id'])) {

                                                    if ($val['id'] == $data[0]['main_category']) {

                                                        echo "<option value='" . $val['id'] . "' selected>" . $val['main_category_name'] . "</option>";
                                                    } else {
                                                        echo "<option value='" . $val['id'] . "'>" . $val['main_category_name'] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value='" . $val['id'] . "'>" . $val['main_category_name'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Sub Category</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select2" id = "subcat" name = "sub_category" required="">
                                            <option value="">Select Category</option>   

                                            <?php
                                            if (isset($_GET['id'])) {
                                                $cat = $dba->getRowAssoc("add_item", array("*"), "id=" . $_GET['id']);
                                                $project = $dba->getRowAssoc("sub_category s inner join main_category m on s.mcat = m.id", array("DISTINCT s.sub_category_name,s.id,s.mcat"), "m.id=" . $cat[0]['main_category']);
                                                foreach ($project as $val) {
                                                    echo "<option " . ($val['id'] == $cat[0]['sub_category'] ? 'selected' : '') . " value='" . $val['id'] . "' data='" . $val['mcat'] . "'>" . $val['sub_category_name'] . "</option>";
                                                }
                                            }
                                            $project = $dba->getRowAssoc("sub_category", array("*"), "1");
                                            foreach ($project as $val) {
                                                if (isset($_GET['id'])) {

                                                    if ($val['mcat'] != $cat[0]['main_category']) {

                                                        echo "<option value='" . $val['id'] . "' data='" . $val['mcat'] . "'disabled>" . $val['sub_category_name'] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value='" . $val['id'] . "'  data='" . $val['mcat'] . "' disabled>" . $val['sub_category_name'] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id = "item_name" name = "item_name" value="<?= (isset($_GET['id'])) ? $data[0]['item_name'] : '' ?>" placeholder = "Item Name" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Rate</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id = "rate" name = "rate" value="<?= (isset($_GET['id'])) ? $data[0]['rate'] : '' ?>" placeholder = "Amount" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control summernote" name="description" id="description"><?= (isset($_GET['id'])) ? $data[0]['description'] : '' ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input form-control" name="image[]"  value="" multiple>
                                            <label class="custom-file-label"  for="customFile"><?= (isset($_GET['id'])) ? "$img File Selected" : 'Choose file' ?></label>
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

        <script src="vendor/select2/select2.min.js"></script>
        <script src="js/select.js"></script>
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>

        <!-- Demo scripts for this page-->
        <script src="js/demo/datatables-demo.js"></script>
        <script src="js/sb-basic.js"></script>

        <!-- summernote -->

        <link href="js/summernote/summernote.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <script src="js/summernote/summernote.js"></script>

        <script type="text/javascript">
                                            $('.summernote').summernote({
                                                toolbar: [
                                                    ['style', ['style']],
                                                    ['fontsize', ['fontsize']],
                                                    ['font', ['bold', 'italic', 'underline', 'clear']],
                                                    ['fontname', ['fontname']],
                                                    ['color', ['color']],
                                                    ['para', ['ul', 'ol', 'paragraph']],
                                                    ['height', ['height']],
                                                    ['insert', ['picture', 'hr']],
                                                    ['table', ['table']],
                                                    ['insert', ['link', 'image', 'doc', 'video']],
                                                ],
                                                height: 400,
                                            });
        </script>
        <script>
            var old = "<?= isset($_GET['id']) ? $data[0]['main_category'] : '' ?>";
            function Filter(cat) {
                $('#subcat option[data="' + old + '"]').prop('disabled', 'true');
                $('#subcat option[data="' + cat.value + '"]').removeAttr('disabled');
                $('#subcat option[value=""]').prop('selected', 'true');
                $("#select2-chosen-2").text($('#subcat option[value=""]').text());
                old = cat.value;
                $(".select2").select2();
            }
        </script>



    </body>
</html>
<?php

function UploadImage($name, $lastID, $strcon) {
    if ($_FILES[$name]['name']) {
        include_once './config/Controls.php';
        $cont = new Controls();
        $uploadResult = $cont->uploadFile($name, array("jpg", "png", "jpeg", "JPG", "JPEG", "PNG"), "Item/", $strcon . "-" . $lastID);
        if ($uploadResult[0]) {
            return "" . $uploadResult[1];
        } else {
            return "";
        }
    } else {
        return "";
    }
}
?>