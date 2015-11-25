<?php
//$prefix = '../';

if(!isset($_POST['path'])){
    echo 'FOO';
    exit();
}

$file = $_POST['path'];

//$result = array();
//if(is_dir($file)){
//    $dirs = scandir($file);
//    for($i = 0; $i < count($dirs); $i++){
//        if(is_dir($dirs[$i])){
//            $result[] = $dirs[$i];
//        }
//    }
//}
//json_encode($result);
if(is_dir($file)){
    echo json_encode(scandir($file));
} else {
    echo json_encode(array());
}

