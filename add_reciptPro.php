<?php
require_once './SendNotification.php';
require_once './config/session_info.php';
require_once './config/DBAdapter.php';
require_once './config.php';
$dba = new DBAdapter();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        unset($_POST['action']);

        //upload image if selected by user
        $filename = $_FILES["image"]["name"];

        $lastID = $dba->getLastID("id", "add_recipe", "1");
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        $imgefolder = ($lastID + 1) . "." . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], 'Recipt/' . $imgefolder);
        if ($_FILES['image']['name']) {
            $_POST['image'] = $imgefolder;
        } else {
            $_POST['image'] = "";
        }
        $_POST['ingrediants_list'] = json_encode($_POST['ingrediants_list'], TRUE);
        $_POST['details'] = $_POST['details'];
        if ($dba->setData("add_recipe", $_POST)){
	        $notification_status = $dba->getRowAssoc("notification", array("status"), "1");
            $status = $notification_status[0]['status'];
            if ($status == 'true') {
			//send notification
            $data = $dba->getRow("firebase_token_list", array("device_token"), "1");
            $serverObject = new SendNotification();
            // $messageBody = array("title" => "New Book", "body" => $_POST['language1_title'], "type" => "Book", "dataList" => $_POST);
            $notification = ["body" => $_POST['name'],
                "title" => "My New Recipe",
                "content_available" => true,
                "sound" => "default",
                "priority" => "high"];
            $data = array_column($data, 0);
            $jsonString = $serverObject->sendPushNotificationToGCMSever($data, $notification, "New Recipe", $_POST['name']);
            $jsonObject = json_decode($jsonString);
            $jsonObject = json_decode(json_encode($jsonObject), TRUE);
            $fcmResult = array("fcm_multicast_id" => $jsonObject['multicast_id'],
                "fcm_success" => $jsonObject['success'],
                "fcm_failure" => $jsonObject['failure'],
                "fcm_error" => json_encode(array_column($jsonObject['results'], 'error')),
                "fcm_type" => "My Recipe",
            );
            $msg = '<script>swal("Success!","Apps Notification Results Success: ' . $jsonObject['success'] . ' Failure: ' . $jsonObject['failure'] . '", "success")</script>';

            $dba->setData("firebase_result", $fcmResult);
	        } else {
                
            }
            $msg = "Recipt created successfully!";
            header('location:add_recipe.php');
        } else {
            $msg = "Category create fail! " . mysqli_error($con);
        }
    } else if ($_POST['action'] == 'edit') {
        if ($_POST['action'] == 'edit' && $_FILES['image']['name'] !== '') {
            $id = $_POST['id'];
            unset($_POST['action']);
            $data = $dba->getRowAssoc("add_recipe", array("*"), "id=" . $id);
            if (file_exists('Recipt/' . $data[0]['image'])) {
                $unlink = unlink('Recipt/' . $data[0]['image']);
            }
            $filename = $_FILES["image"]["name"];
            $lastID = $dba->getLastID("id", "add_recipe", "1");
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            $imgefolder = ($lastID + 1) . "." . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], 'Recipt/' . $imgefolder);
            if ($_FILES['image']['name']) {
                $_POST['image'] = $imgefolder;
            } else {
                $_POST['image'] = "";
            }
            $_POST['ingrediants_list'] = json_encode($_POST['ingrediants_list'], TRUE);
            $_POST['details'] = $_POST['details'];
            if ($dba->updateRow("add_recipe", $_POST, "id=" . $id)) {
                $msg = "updated successfully!";
                header('location:add_recipe.php');
            } else {
                $msg = "update fail!";
            }
        } else {
            $id = $_POST['id'];
            unset($_POST['action']);
            $_POST['ingrediants_list'] = json_encode($_POST['ingrediants_list'], TRUE);
            $_POST['details'] = $_POST['details'];
            if ($dba->updateRow("add_recipe", $_POST, "id=" . $id)) {
                $msg = "updated successfully!";
                header('location:add_recipe.php');
            } else {
                $msg = "update fail!";
            }
        }
    }
}
?>
<?php

if (!function_exists("array_column")) {

    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if (!isset($value[$columnKey])) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            } else {
                if (!isset($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if (!is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }

}
?>