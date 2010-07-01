<?php

/***********************************
//Name: analytics
//Purpose: Insert google analytics 
//          for site tracking
//Returns: code for analytics
***********************************/
function analytics()
{
    $content=<<<HTML
        <script type="text/javascript">
        var gaJsHost = (("https:" == document.location.protocol) ?  "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
        <script type="text/javascript">
        try {
            var pageTracker = _gat._getTracker("UA-15917882-3");
            pageTracker._trackPageview();
        } catch(err) {}</script>
HTML;

    return $content;
}

/**************************************
Name: checkForDeletion
Purpose: check to see if current
         file needs to be deleted
         for having a file size of 0
         It then performs deletion if
         necessary.
Param 1 - $fullPath: path to image folder
Param 2 - $currentName: filename of image
Returns: true or false if deletion succeeded
***************************************/
function checkForDeletion($fullPath, $currentName)
{
    //setup file path 
    $imagePath = $fullPath;  
    $imagePath .= $currentName;

    //check file size
    $currentSize = filesize($imagePath);

    //check filesize 
    if($currentSize <= 20)
    {
        chmod($imagePath, 0777); //change permissions
        $deleted = unlink($imagePath); //delete file
    }

    //if file was not deleted return false
    if(!$deleted)
    {
        return false;
    }

    //if file was deleted then display results and return true
    else 
    {
        echo "bad file deleted: $currentName<br />";
        header("refresh:1;"); //cause a page refresh
        return true;
    }

}

/***************************************
Name: checkNewImages
Purpose: Check to see if thumbnails
         need to be generated 
Param 1 - $fullArray: array of image names
Param 2 - $thumbArray: array of thumbnail names
Param 3 - $fullPath: path to images
Param 4 - $thumbPath: path to thumbnails
***************************************/
function checkNewImages($fullArray, $thumbArray, $fullPath="images/", $thumbPath="thumbs/")
{
    $uno_image_deleted = FALSE;
    $uno_image_resized = FALSE;

    //Loop through all the images in the array
    for($index=0; $index < count($fullArray); $index++)
    {
        $currentName = $fullArray[$index]; //get current filename
        //echo $currentName;
        //$test = array_search($currentName, $thumbArray);
        //echo " Test: ";
        //echo $test;
        //echo "<br />";
        //echo "start check";

        if($resized)
            $uno_image_resized = TRUE;
        $resized= FALSE; //reset resized to false

        //if thumbarray is empty or filename is not in the thumb array
        //create a thumbnail
        if($thumbArray == NULL || !array_search($fullArray[$index],$thumbArray))
        {
            //check to see if file needs to be deleted
            $deleted = checkForDeletion($fullPath, $currentName);

            //if the file was not deleted then resize it
            if(!$deleted) 
            {
                resizeImage($thumbPath, $fullPath,  $currentName); //resize the image
                $resized=TRUE;
            }
            else
                $uno_image_deleted = TRUE;
        }

        
        //echo "$index <br />";
    }
    //echo "done<br />";

    //if image is resized or deleted 
    //don't allow cache of page
    if( $uno_image_deleted || $uno_image_resized)
    {
        echo <<<HTML
            <meta http-equiv="Pragma" content="no-cache">
HTML;
    }
}

/****************************************************
Name: displayPage
Purpose: Inserts bottom portion of page
         which includes the navigation 
         links and the number of images
         available
Param 1 - $content: most of the webpage
                    already made, ready
                    to display
Param 2 - $page: current page number
Param 3 - $indexCount: number of images
Param 4 - $imagesPerPage: number of images per page
****************************************************/
function displayPage($content, $page, $indexCount, $imagesPerPage)
{

    $numPages = getNumPages($indexCount, $imagesPerPage);

    $prev = $page-1; //assign the previous page value
    $next = $page+1; //assign the next page value

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
        //Display Number of Pages
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
        Number Of Images Available: $indexCount <br />
            <div id="linkBox">
HTML;
        if(isAdmin())
        {
            $content.=<<<HTML
                <a href="#">Refresh thumbnails</a> | 
HTML;
        }

        $content.=<<<HTML
                <a href="login/index.php">Main</a> | 
                <a href="login/logout.php">Logout</a>
            </div>
        </div>
HTML;


        $content.=analytics();
        $content.=<<<HTML
        </body>
        </html>
HTML;

 
echo $content; //display the webpage
}

/**********************************************
Name: getNumPages
Purpose: find how many pages to display
         based on how many images we display
         per page
Param 1 - $numImages: total number of images
Param 2 - $imagesPerPage: # of images per page
Returns: the number of pages
**********************************************/
function getNumPages($numImages, $imagesPerPage)
{
    $numPages = $numImages/$imagesPerPage; //Get number of pages
    $numPages = floor($numPages); //make it an int

    //If imagesPerPage does not divide indexCount evenly then
    //we need to add a page
    if($numImages%$imagesPerPage != 0)
        $numPages++;

    return $numPages; //return the number of pages
}

/*********************************************
Name; openreaddir
Purpose: open directory, grab all filenames
        close the direcotry and count number
        of items
Param 1 - $dirName: name of directory to open
Returns: an array of the contents of the directory
         and a count of the number of items
*********************************************/
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


/*********************************************
Name: resizeImage
Purpose: take an image and resize it, then 
        place the image in the target directory
        with teh same file name.
Param 1 - $targetDir: directory to place resized
                      image into
Param 2 - $sourceDir: directory to get image
                      from
Param 3 - $filename: name of file to resize
Param 4 - $percent: percentage to resize image
                    by
*********************************************/
function resizeImage($targetDir, $sourceDir, $filename, $percent=.5)
{
    //echo "resizing <br />";
    // Content type
    //header('Content-type: image/jpeg');

    //Construct filename for source
    $currentImage = $sourceDir;
    $currentImage .= $filename;

    //Construct filename for target
    $targetImage = $targetDir;
    $targetImage .= $filename;


    // Get new dimensions
    //echo "Target dir: $targetDir";
    //echo ", Source dir: $sourceDir";
    //echo ", Filename: $filename";
    list($width, $height) = getimagesize($currentImage); //get image width and height
    $new_width = $width * $percent; //change to new size
    $new_height = $height * $percent; //change to new size

    // Resample
    $image_b = imagecreatetruecolor($new_width, $new_height);
    $image = imagecreatefromjpeg($currentImage);
    imagecopyresampled($image_b, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Output
    imagejpeg($image_b, $targetImage, 100);
}

?>
