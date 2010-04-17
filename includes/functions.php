<?php

function displayPage($content, $page, $indexCount, $imagesPerPage)
{

    $numPages = getNumPages($indexCount, $imagesPerPage);

    $prev = $page-1; //assign the previous page
    $next = $page+1; //assign the next page

        /***********************
        //IF ELSE for Next link
        ***********************/

    if($prev>0)
        $content.=<<<HTML
        <div style="text-align: center;">
            <a href="?page=$prev">&lt;&lt; prev</a> 

HTML;

    //else start the centering anyway
    else
        $content.=<<<HTML
        <div style="text-align: center;">
HTML;

        /**********************
        //Number of Pages
        **********************/
        $content.=<<<HTML
        Page $page of $numPages 


HTML;

        /*********************
        //IF ELSE for Prev link
        **********************/

        if($next <= $numPages)
            $content.=<<<HTML
                <a href="?page=$next">next &gt;&gt;</a><br />
HTML;
        else
            $content.=<<<HTML
                <br />
HTML;


        /*********************************
        //Show number of Images available
        *********************************/
        $content.=<<<HTML
        Number Of Images Available: $indexCount </div>
HTML;


        $content.=<<<HTML
        </body>
        </html>
HTML;

 
echo $content;
}

function getNumPages($numImages, $imagesPerPage)
{
    $numPages = $numImages/$imagesPerPage; //Get number of pages
    $numPages = floor($numPages);

    //If 9 does not divide indexCount evenly then
    //we need to add a page
    if($numImages%$imagesPerPage != 0)
        $numPages++;

    return $numPages;
}

function checkNewImages($fullArray, $thumbArray, $fullPath="images/full/", $thumbPath="images/")
{
    for($index=0; $index < count($fullArray); $index++)
    {
        $currentName = $fullArray[$index];
        //echo $currentName;
        //$test = array_search($currentName, $thumbArray);
        //echo " Test: ";
        //echo $test;
        //echo "<br />";
        //echo "start check";

        if(!array_search($fullArray[$index],$thumbArray))
                resizeImage($thumbPath, $fullPath,  $currentName);

        //echo "$index <br />";
    }
    //echo "done<br />";

}

function resizeImage($targetDir, $sourceDir, $filename, $percent=.5)
{
    //echo "resizing <br />";
    // Content type
    //header('Content-type: image/jpeg');
    $currentImage = $sourceDir;
    $currentImage .= $filename;
    $targetImage = $targetDir;
    $targetImage .= $filename;


    // Get new dimensions
    //echo "Target dir: $targetDir";
    //echo ", Source dir: $sourceDir";
    //echo ", Filename: $filename";
    list($width, $height) = getimagesize($currentImage);
    $new_width = $width * $percent;
    $new_height = $height * $percent;

    // Resample
    $image_p = imagecreatetruecolor($new_width, $new_height);
    $image = imagecreatefromjpeg($currentImage);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Output
    imagejpeg($image_p, $targetImage, 100);
}

function openreaddir($dirName)
{
    // open this directory 
    $myDirectory = opendir($dirName);
 
    // get each entry
    while($entryName = readdir($myDirectory))
    {
        //exclude current directory and parent
        if (substr("$entryName", 0) != "." && substr("$entryName", 0) != "..")
            $dirArray[] = $entryName;
    }
 
    // close directory
    closedir($myDirectory);

    //count elements in array
    $count = count($dirArray);

    return array ($dirArray, $count);
}

?>
