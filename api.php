<?php

include_once 'config/DBAdapter.php';
include 'config.php';
$dba = new DBAdapter();
//Authorization
$token = '';
$Authorization = Authorization;
$request_auth = getallheaders();
if (!empty($request_auth['Authorization'])) {
    $request_auth = $request_auth['Authorization'];
    if (!isset($_POST['name'])) {
        $response['status'] = false;
        $response['msg'] = "Unknown requested name..";
        echo json_encode($response);
        die();
    }
    if (!isset($_POST['user_email'])) {
        $response['status'] = false;
        $response['msg'] = "Unknown requested email..";
        echo json_encode($response);
        die();
    }
    $tmp = Auth($_POST['name'], $_POST['user_email']);
    if (!$tmp) {
        $response['status'] = false;
        $response['msg'] = "Unauthorised request";
        echo json_encode($response);
        die();
    }
    if ($_POST['name'] == 'main_category') {

        $data = $dba->getRowAssoc("main_category", array("*"), "1");
        $main_category = array();
        if (!empty($data)) {
            foreach ($data as $subData) {
                $main_category[] = $subData;
            }
        }
        $file = 'http://recipe.lpktechnosoft.com/Main-Category/';
        if (!empty($main_category)) {
            echo json_encode(array("status" => TRUE, "data" => $main_category, "msg" => "data get successfully", "image-url" => $file));
        } else {
            echo json_encode(array("status" => FALSE, "data" => $main_category, "msg" => "No Data available", "image-url" => $file));
        }
        die();
    } elseif ($_POST['name'] == 'view_rating') {
        if (isset($_POST['recipe_id']) && ($_POST['device_id'])) {
            $data = $dba->getRowAssoc("rating_table", array("*"), "recipe_id=" . $_POST['recipe_id'] . " and device_id='" . $_POST['device_id'] . "'");
            $rate = array();
            if (!empty($data)) {
                foreach ($data as $subData) {
                    $rate[] = $subData;
                }
            }
            if (!empty($rate)) {
                echo json_encode(array("status" => TRUE, "data" => $rate, "msg" => "data get successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "data" => $rate, "msg" => "No Data available"));
            }
        } else {
            $response['status'] = false;
            $response['msg'] = "No data found";
            echo json_encode($response);
            die();
        }
        die();
    } elseif ($_POST['name'] == 'view_recipe') {
        if (isset($_POST['category_id'])) {

            $data = $dba->getRowAssoc("add_recipe a INNER JOIN main_category m ON a.category_id=m.id left join rating_table rt on rt.recipe_id=a.id", array("a.*,m.main_cat_name,(IFNULL(FORMAT(((round(2*avg(rt.rating),0))/2),1),0))*1 as rating"), "a.category_id=" . $_POST['category_id'] . " and a.id GROUP by a.id");
            $view_item = array();
            if (!empty($data)) {
                foreach ($data as $subData) {
                    $view_item[] = $subData;
                }
            }
            $file = 'http://recipe.lpktechnosoft.com/Recipt/';
            if (!empty($view_item)) {
                echo json_encode(array("status" => TRUE, "data" => $view_item, "msg" => "data get successfully", "image-url" => $file), TRUE);
            } else {
                echo json_encode(array("status" => FALSE, "data" => $view_item, "msg" => "No Data available", "image-url" => $file));
            }
        } else {
            $response['status'] = false;
            $response['message'] = "No data found";
            echo json_encode($response);
            die();
        }
        die();
    } elseif ($_POST['name'] == 'add_rating') {
        unset($_POST['name']);
        $data = $dba->getRowAssoc("rating_table", array("*"), "recipe_id=" . $_POST['recipe_id'] . " AND user_email='" . $_POST['user_email'] . "'");

        if ($data[0]['user_email'] == $_POST['user_email'] and $data[0]['recipe_id'] == $_POST['recipe_id']) {

            if ($dba->updateRow("rating_table", $_POST, "recipe_id=" . $_POST['recipe_id'] . " AND user_email='" . $_POST['user_email'] . "'")) {
                echo json_encode(array("status" => TRUE, "msg" => "Data Update Successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "msg" => "error"));
            }
        } else {

            if ($dba->setData("rating_table", $_POST)) {

                echo json_encode(array("status" => TRUE, "msg" => "Data Insert Successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "msg" => "error"));
            }
        }
        die();
    } elseif ($_POST['name'] == 'add_user') {

        unset($_POST['name']);
        $lastID = $dba->getLastID("id", "user_details", "1");

        $filename = $_FILES["user_image"]["name"];
        $imgefolder = ($lastID + 1) . "-" . $filename;
        move_uploaded_file($_FILES['user_image']['tmp_name'], 'user/' . $imgefolder);
        if ($_FILES['user_image']['name']) {
            $_POST['user_image'] = $imgefolder;
        } else {
            $_POST['user_image'] = "";
        }

        if ($dba->setData("user_details", $_POST)) {

            echo json_encode(array("status" => TRUE, "msg" => "Data Insert Successfully"));
        } else {

            echo json_encode(array("status" => FALSE, "msg" => "error"));
        }
        die();
    } elseif ($_POST['name'] == 'last_recipe') {
        $data = $dba->getRowAssoc("add_recipe", array("id,name,image"), "id ORDER BY id DESC LIMIT 3");
        $last_recipe = array();
        if (!empty($data)) {
            foreach ($data as $subData) {
                $last_recipe[] = $subData;
            }
        }
        $file = 'http://recipe.lpktechnosoft.com/Recipt/';
        if (!empty($last_recipe)) {
            echo json_encode(array("status" => TRUE, "data" => $last_recipe, "msg" => "data get successfully", "image-url" => $file), TRUE);
        } else {
            echo json_encode(array("status" => FALSE, "data" => $last_recipe, "msg" => "No Data available", "image-url" => $file));
        }
        die();
    }
    // Firebase Tokrn List
    if ($_POST['name'] == 'firebase_token_list') {
        unset($_POST['name']);
        $data = $dba->getRow("firebase_token_list", array("device_id"), "device_id='" . $_POST['device_id'] . "'");

        if (empty($data)) {
            if ($dba->setData("firebase_token_list", $_POST)) {

                echo json_encode(array("status" => TRUE, "data" => "Data Insert Successfully"));
            } else {

                echo json_encode(array("status" => FALSE, "msg" => "error"));
            }
        } else {

            if ($dba->updateRow("firebase_token_list", $_POST, "device_id='" . $_POST['device_id'] . "'")) {
                echo json_encode(array("status" => TRUE, "msg" => "Data Update Successfully"));
            } else {
                echo json_encode(array("status" => FALSE, "msg" => "error"));
            }
        }
        die();
    }
} else {
    $response['status'] = false;
    $response['msg'] = "Unknown request";
    echo json_encode($response);
    die();
}

function Auth($apiname, $user_email) {
    $request_auth = getallheaders();
    $request_auth = $request_auth['Authorization'];
    $Id = '260898';
    $jwt = hash('sha256', $Id . $apiname);
    echo $jwt;
    if ($request_auth == $jwt) {
        return TRUE;
    } else {
        return FALSE;
    }
}
?>

