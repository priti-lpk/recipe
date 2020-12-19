<?php

require_once './config/session_info.php';
require_once './config/DBAdapter.php';
include_once 'config.php';
$dba = new DBAdapter();

if (isset($_POST['action']) == "changeStatus") {

    $field = array("status" => $_POST['status']);

    $result1 = $dba->updateRow("notification", $field, "id=" . $_POST['cid']);

    $responce = array();

    if ($result1) {

        $responce = array("status" => TRUE, "msg" => "Operation Successful!");
    } else {

        $responce = array("status" => FALSE, "msg" => "Oops Operation Fail");
    }
    echo json_encode($responce);
}
?>