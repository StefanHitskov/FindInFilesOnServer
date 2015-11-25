<?php

if(!isset($_POST['path'])){
    echo 'FOO';
    exit();
}

$file = $_POST['path'];

$result = array();
if(is_dir($file)){
    $dirs = scandir($file);
    for($i = 2; $i < count($dirs); $i++){
        if(strpos($dirs[i], '.') !== 0){
            if(is_dir($file.'/'.$dirs[$i])){
                $result[] = $file.'/'.$dirs[$i];
            }
        }

//        $result[] = $dirs[$i];
    }
}
echo json_encode($result);