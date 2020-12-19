<!DOCTYPE html>
<?php
ob_start();
include_once './config/session_info.php';
?>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Change Password</title>

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
                            <a href="#">Change Password</a>
                        </li>

                    </ol>

                    <!-- Icon Cards-->
                    <div class="row">
                        <div class="col-xl-10">
                            <form action="" method="post" enctype="multipart/form-data">
                                <?php
                                include_once './config/session_info.php';
                                if ($_SESSION['username']) {
                                    ?>
                                    <input type = "hidden" name = "pwd_id" id = "pwd_id" value = "<?php echo $_SESSION['username']; ?>">

                                <?php } ?>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Old password</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id = "old_pwd" name = "old_pwd" value="" placeholder = "Old password" required=""/>
                                    </div>
                                </div>
                                <div class = "col-md-12">
                                    <p id = 'waitFor'></p>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">New Password</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="" id = "new_pwd" name = "new_pwd" placeholder = "New password" required/>
                                    </div>
                                </div>
                                <div class = "form-group row">
                                    <label for = "example-text-input" class = "col-sm-2 col-form-label">Confirm password</label>
                                    <div class = "col-sm-10">
                                        <input class = "form-control" type = "text" value = "" id = "con_pwd" name = "con_pwd" placeholder = "Confirm password" required>
                                    </div>
                                </div>
                                <div class = "col-md-12">
                                    <p id = 'compare'></p>
                                </div>

                                <div class="form-group row">  
                                    <div class="col-sm-2"> </div>
                                    <div class="col-sm-10">
                                        <button id = "changePass" class="btn btn-primary btn-block w-md waves-effect waves-light" type="button">Submit</button>
										<br>
                                        <center><div id="msg1"style="color: red;"></div></center>
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
  
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>

        <!-- Demo scripts for this page-->
        <script src="js/demo/datatables-demo.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                var oldMatched = 0;
                var bothMatched = 0;
//                                $('#old_pwd').on('input', function () {
//                                    $('#waitFor').html('checking your password..');
//                                    if ($('#old_pwd').val() == '')
//                                    {
//                                        $('#waitFor').html('old password can not be blank!');
//                                        oldMatched = 0;
//                                    }
//                                });
                $('#old_pwd').on('blur', function () {
                    var dataString = 'id=' + $('#pwd_id').val() + '&old=' + $('#old_pwd').val();

                    // alert(dataString);
                    if (!$('#old_pwd').val() == '')
                    {
                        $.ajax({
                            type: "POST",
                            url: "change.php",
                            data: dataString,
                            cache: false,
                            success: function (data) {
                                // alert(data);
                                if (data == 1)
                                {
                                    $('#waitFor').html('Password matched');
                                    oldMatched = 1;
                                } else {
                                    $('#waitFor').html('Password does not match!');
                                    oldMatched = 0;
                                    $('#old_pwd').focus();
                                }
                            }
                        });
                    }
                });
                $('#new_pwd').on('blur', function () {
                    if ($('#new_pwd').val() == '')
                    {
                        $('#compare').html('new password can not be blank!');
                        bothMatched = 0;
                    } else
                    {
                        $('#compare').html('please confirm password');
                    }

                });
                $('#con_pwd').on('blur', function () {
                    if ($('#new_pwd').val() != $('#con_pwd').val())
                    {
                        $('#compare').html('Both passwords mismatched!');
                        bothMatched = 0;
                    } else
                    {
                        $('#compare').css('color', 'green');
                        $('#compare').html('Passwords matched');
                        bothMatched = 1;
                    }
                    if ($('#con_pwd').val() == '')
                    {
                        $('#compare').html('confirm password can not be blank!');
                        bothMatched = 0;
                    }
                });
                $('#changePass').click(function () {
					 $('#msg1').html('you can not change password becouse is trial demo.');
                    // if (oldMatched == '0')
                    // {
                        // $('#waitFor').html('provide valid password!');
                        // $('#old_pwd').focus();
                    // }
                    // if (bothMatched == '0')
                    // {
                        // $('#compare').html('please check new and confirm password!');
                        // $('#new_pwd').focus();
                    // }
                    // if ((oldMatched == '1') && (bothMatched == '1'))
                    // {
                        // var dataString = 'change=' + $('#pwd_id').val() + '&new=' + $('#new_pwd').val();
                        // $.ajax({
                            // type: "POST",
                            // url: "change.php",
                            // data: dataString,
                            // cache: false,
                            // beforeSend: function () {
                                // $('#changePass').html('Changing Now...');
                            // },
                            // success: function (data) {
                                 alert(data);
                                // if (data == 1)
                                // {
                                    				$('#compare').html('Password changed successfully');
                                    // location.href = alert('Password changed Successfully');
                                    // top.location = 'change_password.php';
                                    // $('#changePass').html('Change Now');
                                    // $('#changePass').attr('disabled', true);

                                // } else
                                // {
                                    				$('#compare').html('Couldn\'t Change Password! Try Again');
                                    // location.href = alert('Couldn\'t Change Password! Try Again');
                                    // top.location = 'change_password.php';
                                    // $('#changePass').html('Ooops!');
                                    // $('#changePass').attr('disabled', true);

                                // }
                            // }});
                    // }
                });
            });
        </script>
    </body>

</html>
