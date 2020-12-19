<!DOCTYPE html>
<?php
if ($_POST) {
    require_once './config/DBAdapter.php';
    $dba = new DBAdapter();
    $data = $dba->getRowAssoc("admin", array("*"), "username='" . $_POST['username'] . "' and password='" . md5($_POST['password']) . "'");
    if (!empty($data)) {
        if ($data[0]['username'] === $_POST['username'] && $data[0]['password'] === md5($_POST['password'])) {
            session_start();
            $_SESSION['username'] = $data[0]['username'];
            $_SESSION['sid'] = $data[0]['id'];
            header("Location: dashboard.php");
        } else {
            $msg = "Authentication Fail!";
        }
    } else {
        $msg = "Authentication Fail!";
    }
}
?>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Login</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">

    </head>

    <body class="bg-dark">

        <div class="container">
            <div class="card card-login mx-auto mt-5">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="post" action="index.php">
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="text" id="inputEmail" class="form-control" name="username" placeholder="Email address" required="required" autofocus="autofocus">
                                <label for="inputEmail">Username</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required="required">
                                <label for="inputPassword">Password</label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                        <div id="errormsg"><br>
                            <center><?php echo ($_POST) ? $msg : ''; ?></center>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    </body>

</html>
