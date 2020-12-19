<?php

require_once './config/session_info.php';
require_once './config/DBAdapter.php';
include_once 'config.php';

$dba = new DBAdapter();

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        unset($_POST['action']);

        $lastID = $dba->getLastID("id", "main_category", "1");
        //upload image if selected by user
        $filename = $_FILES["main_image"]["name"];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        $imgefolder = ($lastID + 1) . "." . $ext;
        move_uploaded_file($_FILES['main_image']['tmp_name'], 'Main-Category/' . $imgefolder);
        if ($_FILES['main_image']['name']) {
            $_POST['main_image'] = $imgefolder;
        } else {
            $_POST['main_image'] = "";
        }

        if ($dba->setData("main_category", $_POST)) {
            $msg = "Category created successfully!";
            header('location:main_category.php');
        } else {
            $msg = "Category create fail! " . mysqli_error($con);
        }
    } else if ($_POST['action'] == 'edit') {
        if ($_POST['action'] == 'edit' && $_FILES['main_image']['name'] !== '') {
            $id = $_POST['id'];
            $data = $dba->getRowAssoc("main_category", array("*"), "id=" . $id);

            $filename = $_FILES["main_image"]["name"];
           
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            $imgefolder = ($id) . "." . $ext;
            move_uploaded_file($_FILES['main_image']['tmp_name'], 'Main-Category/' . $imgefolder);
            if ($_FILES['main_image']['name']) {
                $_POST['main_image'] = $imgefolder;
            } else {
                $_POST['main_image'] = "";
            }
            unset($_POST['id'], $_POST['action']);
            if ($dba->updateRow("main_category", $_POST, "id=" . $id)) {
                $msg = "Category updated successfully!";

                header('location:main_category.php');
            } else {
                $msg = "Category update fail!";
            }
        } else {
            $id = $_POST['id'];
            unset($_POST['action']);
            unset($_POST['id']);
            if ($dba->updateRow("main_category", $_POST, "id=" . $id)) {
                $msg = "updated successfully!";
                header('location:main_category.php');
            } else {
                $msg = "update fail!";
            }
        }
    }
}
?>