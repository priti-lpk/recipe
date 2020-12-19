<?php
if (!defined('SERVER_KEY')) define("SERVER_KEY", "AAAATal48tE:APA91bFjVKqf5Uyhf4B7Dn42evPM1iPG79ZNYr_zkAM7G9mhsfWbbSjrshjW4kTXNfqg0gTD0G-a8xWR0FTgiaUWzu5SrclyCinx-jwkYoDAeT9OIqnyny30B5L-nFcTqs4vU8FhAYj2");
if (!defined('Authorization')) define('Authorization', '260898');
$db_user = "root";
$db_password = "";
$db_host = "localhost";
$db_name = "recipe";
$con = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$con) {
   echo "can not connect to database " . mysql_error();
   die();
} 

//$db_user = "u184288993_recip";
//$db_password = "recipe@lpk#19";
//$db_host = "localhost";
//$db_name = "u184288993_recip";
?>