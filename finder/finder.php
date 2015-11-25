<?php
if(!isset($_POST['search']) && !isset($_POST['root'])){
    echo "error";
    exit();
}

$rec = true;

if(isset($_POST['rec'])){
    $rec = $_POST['rec'];
}

if($rec){

}



$count = search($_POST['root'], $_POST['search']);

//echo '<p>'.$count.' matches</p>';
echo '<p>end</p>';
function findInFile($file, $str){
    $count = 0;
    $handle = @fopen($file, "r");
    $line = 1;
    if ($handle) {
        while (($buffer = fgets($handle)) !== false) {
            $pos = strpos($buffer, $str);
            if($pos !== false){
                $count++;
                echo '<p>in file '.$file.', at line :'.$line.', at pos '.$pos.'</p>';
            }
            $line++;
        }
        if (!feof($handle)) {
            echo "Error: unexpected fgets() fail\n";
        }
        fclose($handle);
    }
    return $count;
}

function lightSearch($dir){

}

function search($file, $str){
    $count = 0;
    if(is_dir($file)){
        $entries = scandir($file);
        foreach($entries as $entry) {
            if($entry != '.' && $entry != '..') {
                $count = search($file . '/' . $entry, $str);
            }
        }
    } else {
        $count += findInFile($file, $str);
    }
    return $count;
}

function list_dir($dir, $str){
    $count = 0;
    $entries = scandir($dir);
    foreach($entries as $entry) {
        if(is_dir($dir.'/'.$entry)){
            if($entry != '.' && $entry != '..'){
                $count += list_dir($dir.'/'.$entry, $str);
            }
        } else if($entry != '.' && $entry != '..'){
            $count += findInFile($dir.'/'.$entry, $str);
//            if(strpos($entry, '.jpg') === false && strpos($entry, '.png') === false){
//                findInFile($dir.'/'.$entry, $str);
//            }
        }
    }
    return $count;
}
