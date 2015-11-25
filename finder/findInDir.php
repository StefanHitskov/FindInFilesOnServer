<?php
if(!isset($_POST['search']) && !isset($_POST['root'])){
    echo "error";
    exit();
}

$file = $_POST['root'];
$str = $_POST['search'];


search($file, $str);

function search($file, $str){
    if(!is_dir($file)){
        findInFile($file, $str);
    } else {
        $entries = scandir($file);
        foreach ($entries as $entry) {
            if(!is_dir($file.'/'.$entry)){
//            echo $entry .'.. ';
                findInFile($file.'/'.$entry, $str);
            }
        }
    }
}

function findInFile($file, $str){
    $handle = @fopen($file, "r");
    $line = 1;
    if ($handle) {
        while (($buffer = fgets($handle)) !== false) {
            $pos = strpos($buffer, $str);
            if($pos !== false){
                echo '<p>in file '.$file.', at line :'.$line.', at pos '.$pos.'</p>';
            }
            $line++;
        }
        if (!feof($handle)) {
            echo "Error: unexpected fgets() fail\n";
        }
        fclose($handle);
    }
}