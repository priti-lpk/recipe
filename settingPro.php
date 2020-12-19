<?php

require_once './config/session_info.php';
require_once './config/DBAdapter.php';
require_once './config.php';
$dba = new DBAdapter();

if (isset($_POST['action'])) {
    // if ($_POST['action'] == 'add') {
        // unset($_POST['action']);
        // if ($dba->setData("setting", $_POST)) {
            // $msg = "Language created successfully!";
            // header('location:setting.php');
        // } else {
            // $msg = "Language create fail! " . mysqli_error($con);
        // }
    // } else 
	if ($_POST['action'] == 'edit') {

            unset($_POST['action']);
            if ($dba->updateRow("setting", $_POST, "1")) {
                $msg = "updated successfully!";
                header('location:setting.php');
            } else {
                $msg = "update fail!";
            }   
    }
}
?>