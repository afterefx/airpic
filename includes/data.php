<?php
include_once 'settings.php';

// open this directory 
list($thumbArray, $thumbCount) = openreaddir($thumbDir);
list($fullArray, $fullCount) = openreaddir($fullDir);

sort($fullArray); //sort the array in ascending order
$fullArray = array_reverse($fullArray); //reverse array to descending order

//check for new images to generate thumbnails
checkNewImages($fullArray, $thumbArray); 

//get the page number from the url
$page=$_GET['page'];

//if the page is not set in the URL or is not a number
//set it to page 1
if($page == NULL || !is_numeric($page)) 
    $page = 1; //it must be page 1

//get the number of pages that are available
$availablePages = getNumPages($fullCount, $imagesPerPage);

//if a number < 1 or greater than the number
//of available pages shows up then set
//the page number to 1
if($page > $availablePages || $page < 1)
    $page = 1;

?>

