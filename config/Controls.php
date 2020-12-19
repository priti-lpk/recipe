<?php

class Controls {

    //put your code here

    function uploadFile($filename, $fileType, $destPath, $myName) {

        if (is_uploaded_file($_FILES[$filename]['tmp_name'])) {

            $path = $_FILES[$filename]['name'];

            $ext = pathinfo($path, PATHINFO_EXTENSION);

            if (in_array($ext, $fileType)) {

                $myName = $myName . "." . $ext;

                $destPath = $destPath . $myName;

                if (move_uploaded_file($_FILES[$filename]['tmp_name'], $destPath)) {

                    $result = array(true, $myName, "Upload Successfully");

                    return $result;
                } else {

                    $result = array(FALSE, "File upload fail!");

                    return $result;
                }
            } else {

                $result = array(false, "File type not supported");

                return $result;
            }
        } else {

            $result = array(false, "File read fail");

            return $result;
        }
    }

    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

   
    

}
?>



