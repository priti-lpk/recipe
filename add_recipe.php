<!DOCTYPE html>
<?php
require_once './config/session_info.php';
require_once './config/DBAdapter.php';
include_once 'config.php';
$dba = new DBAdapter();
//get data for edit
if (isset($_GET['id'])) {
    $data = $dba->getRowAssoc("add_recipe", array("*"), "id=" . $_GET['id']);
//    echo $data[0]['category_id'];
}
?>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Add Recipe</title>

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
                            <a href="">Add Recipe</a>
                        </li>

                    </ol>

                    <!-- Icon Cards-->
                    <div class="row">
                        <div class="col-xl-10">
                            <form action="add_reciptPro.php" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control select2" id = "name" name = "name" value="<?= (isset($_GET['id'])) ? $data[0]['name'] : '' ?>" placeholder = "Name" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Image</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input form-control" name="image"  value="">
                                            <label class="custom-file-label"  for="customFile"><?= (isset($_GET['id'])) ? $data[0]['image'] : 'Choose File' ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Select Category</label>
                                    <div class="col-sm-10">
                                        <select type="text" class="form-control select2 chosen" id = "mcat" name = "category_id" required=""/>
                                        <option>Select Category</option>       
                                        <?php
                                        $dba = new DBAdapter();
                                        $data1 = $dba->getRow("main_category", array("id", "main_cat_name"), "1");
                                        foreach ($data1 as $subData) {
                                            echo "<option " . ($subData[0] == $data[0]['category_id'] ? 'selected' : '') . " value=" . $subData[0] . ">" . $subData[1] . "</option>";
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Details</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="details" id="details"><?= (isset($_GET['id'])) ? $data[0]['details'] : '' ?></textarea>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Video Url</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control select2" id = "video_url" name = "video_url" value="<?= (isset($_GET['id'])) ? $data[0]['video_url'] : '' ?>" placeholder = "Youtube Video URL" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Author Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control select2" id = "author_name" name = "author_name" value="<?= (isset($_GET['id'])) ? $data[0]['author_name'] : '' ?>" placeholder = "Author Name" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Duration</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control select2" id = "duration" name = "duration" value="<?= (isset($_GET['id'])) ? $data[0]['duration'] : '' ?>" placeholder = "Duration" required=""/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Ingrediants List</label>
                                    <div class="col-sm-10">
                                        <table id="myTable" class="table order-list" >
                                            <tbody>
                                                <?php
                                                if (isset($_GET['id'])) {
                                                    $data = $data[0]['ingrediants_list'];
//                                        echo $data;
                                                    $json = json_decode($data, TRUE);
//                                        print_r($json);
                                                    $count = sizeof($json);
//                                        echo $count;
                                                    $title = "";
                                                    $j = 0;
                                                    ?>

                                                    <?php
                                                    for ($i = 0; $i < $count; $i++) {
                                                        $title = array_slice($json, $j, $count);
//                                            print_r($title);
                                                        ?>

                                                        <tr style="width:400px;" >
                                                            <td class="col-sm-6" id="row<?php echo ($i + 1); ?>">
                                                                <input type="text" style="width:400px;" name="ingrediants_list[]" value="<?php echo $title[0]; ?>"  class="form-control" />
                                                            </td>
                                                            <td class="col-sm-2" style="width: 80px;"><a class="deleteRow"></a><input type="button" style="margin-left:50px;font-size: 20px;font-weight: bold;" class="ibtnDel btn btn-md "  value="-">
                                                            </td>
                                                        </tr>

                                                        <!--</div>-->

                                                        <?php
                                                        $j += 1;
                                                    }
                                                } else {
                                                    ?>

                                                    <tr style="width:400px;">
                                                        <td class="col-sm-6">
                                                            <input type="text" style="width:400px;" name="ingrediants_list[]"  class="form-control" />
                                                        </td>
                                                        <td class="col-sm-2"><a class="deleteRow"></a>
                                                        </td>
                                                    </tr>

                                                    </div>                                               

                                                <?php } ?>
                                            </tbody>
<!--                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" style="text-align: left;">
                                                    </td>
                                                </tr>
                                            </tfoot>-->
                                        </table>

                                        <input type="button" style="margin-top: -115px;margin-left: 470px;font-size: 20px;font-weight: bold;" class="btn" id="addrow" value="+" />

                                    </div>

                                </div>
                                <div class="form-group row">  
                                    <div class="col-sm-2"> </div>
                                    <div class="col-sm-10">
                                        <?= (isset($_GET['id'])) ? '<input type="hidden" name="id" value="' . $_GET['id'] . '">' : '' ?>
                                        <input type="hidden" name="action" id='action' value="<?= (isset($_GET['id'])) ? 'edit' : 'add' ?>">
                                        <button  type="submit" id='submit-button' class="btn btn-primary btn-block w-md waves-effect waves-light" >Submit</button>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div><hr>


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
        <script src="vendor/select2/select2.min.js"></script>
        <script src="js/sb-basic.js"></script>
        <script src="js/select.js"></script>
        <!-- Demo scripts for this page-->
        <script src="js/demo/datatables-demo.js"></script>

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
                    ['insert', ['link', 'image', 'doc', 'video', 'code']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                height: 400,
            });
        </script>
        <script>
            $(document).ready(function () {
                var counter = 0;

                $("#addrow").on("click", function () {
                    var newRow = $("<tr style='width:400px;'>");
                    var cols = "";

                    cols += '<td><input type="text" style="width:400px;" class="form-control" name="ingrediants_list[]' + counter + '"/></td>';

                    cols += '<td><input type="button" style="margin-left:-310px;font-size: 20px;font-weight: bold;" class="ibtnDel btn btn-md "  value="-"></td>';
                    newRow.append(cols);
                    $("table.order-list").append(newRow);
                    counter++;
                });

                $("table.order-list").on("click", ".ibtnDel", function (event) {
                    $(this).closest("tr").remove();
                    counter -= 1
                });


            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.chosen').select2();
            });

        </script>
    </body>

</html>
