<?php
include_once 'settings.php';

// open this directory 
list($thumbArray, $thumbCount) = openreaddir($thumbDir);
list($fullArray, $fullCount) = openreaddir($fullDir);

checkNewImages($fullArray, $thumbArray);

//get the page number
$page=$_GET['page'];

if($page == NULL || !is_numeric($page)) //if the page is not set in the URL
    $page = 1; //it must be page 1

//check for large numbers
$availablePages = getNumPages($fullCount, $imagesPerPage);
if($page > $availablePages || $page < 1)
    $page=1;




?>

