<?php

include_once './config/DBAdapter.php';
$dba = new DBAdapter();
if (isset($_GET['mid'])) {
    $data = $dba->getRowAssoc("main_category", array("main_image"), "id=" . $_GET['mid']);
    $image = $data[0]['main_image'];
    $unlink = unlink('Main-Category/' . $image);
    $delete = $dba->delRow("main_category", $_GET['mid']);
    if ($delete) {
        echo "<script>alert('successfully Detail deleted!');top.location='main_category.php';</script>";
    } else
        echo "<script>alert('Oops, Could not delete the Image\nTry Again!');</script>";
}
else if (isset($_GET['rid'])) {
    $delete = $dba->delRow("rating_table", $_GET['rid']);
    if ($delete) {
        echo "<script>alert('successfully Detail deleted!');top.location='view_recipe_rating.php';</script>";
    } else
        echo "<script>alert('Oops, Could not delete the Image\nTry Again!');</script>";
}
elseif (isset($_GET['uid'])) {
    $data = $dba->getRowAssoc("user_details", array("user_image"), "id=" . $_GET['uid']);
    $image = $data[0]['user_image'];
    $unlink = unlink('user/' . $image);
    $delete = $dba->delRow("user_details", $_GET['uid']);
    if ($delete) {
        echo "<script>alert('successfully Detail deleted!');top.location='view_user.php';</script>";
    } else
        echo "<script>alert('Oops, Could not delete the Image\nTry Again!');</script>";
}
elseif (isset($_GET['recid'])) {
    $data = $dba->getRowAssoc("add_recipe", array("image"), "id=" . $_GET['recid']);
    $image = $data[0]['image'];
    $unlink = unlink('Recipt/' . $image);
    $delete = $dba->delRow("add_recipe", $_GET['recid']);
    if ($delete) {
        echo "<script>alert('successfully Detail deleted!');top.location='view_recipe.php';</script>";
    } else
        echo "<script>alert('Oops, Could not delete the Image\nTry Again!');</script>";
}
?>