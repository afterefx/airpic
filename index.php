<?php
include_once 'includes/display.php';
include_once 'login/display.php';

session_start();

connect();

$result = checkForSession();

if($result)
{
    //start gallery
    $content.=<<<HTML
        <div id="gallery">
HTML;

    //make form for admin to delete images
    if(isAdmin())
    {
        $content.=<<<HTML

            <form method="get" action="http://mobile.afterpeanuts.com/">

HTML;
    }

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

        if(isAdmin())
            $content.=createDeleteLinks($fullArray, $page, $imagesPerPage);
            

    }

    //close the gallery
    if(isAdmin())
    {
        $content.=<<<HTML
            <input type="submit" value="Delete" />
            </form>

HTML;
    }

    $content.=<<<HTML
    </div>
HTML;

    //display the webpage
    displayPage($content, $page, $fullCount, $imagesPerPage);
}    
else
    redirect("login/auth.php?page=http://mobile.afterpeanuts.com/");




//====================================================================
    //functions ====================================================== 
//====================================================================
function createDeleteLinks($imgNameArray, $page, $imagesPerPage)
{
    $index=($page-1)*$imagesPerPage; 
    $content.=<<<HTML
        <div id="row">

HTML;
        //put 3 images on the row
        for($countRow=0; $countRow < 3; $countRow++)
        {
            if($imgNameArray[$index] != NULL) //display image if one is available
            {
                $content.=<<<HTML
                    <input type="checkbox" name="q" value="$imgNameArray[$index]" />
HTML;
            }
            $index++; //increment index
        }

        //end the row
        $content.=<<<HTML
    </div>
HTML;

        return $content;
}
?>
