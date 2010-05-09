<?php
include_once 'includes/display.php';

//start gallery
$content.=<<<HTML
    <div id="gallery">
HTML;

//display the images
for($index=($page-1)*$imagesPerPage; $index < ($page * $imagesPerPage); NULL)
{
    $content.=<<<HTML
        <div id="row">
HTML;

    //put 3 images on the row
    for($countRow=0; $countRow < 3; $countRow++)
    {
        if($fullArray[$index] != NULL) //display image if one is available
        {
            $content.=<<<HTML
            <div id="pic">
            <a href="$fullDir$fullArray[$index]">
            <span class="frame-outer " style="display:inline;">
            <span><span><span><span>
            <img src="$thumbDir$fullArray[$index]" height="20%"/>
            </span></span></span></span></span></a></div> 
HTML;
        }
        $index++; //increment index
    }

    //end the row
    $content.=<<<HTML
</div>
HTML;
}

//close the gallery
$content.=<<<HTML
</div>
HTML;

//display the webpage
displayPage($content, $page, $fullCount, $imagesPerPage);
 
?>
