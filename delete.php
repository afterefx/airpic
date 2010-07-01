<?php
include_once 'includes/display.php';
include_once 'login/display.php';

session_start();

connect();

$result = checkForSession();

if($result)
{
    //make form for admin to delete images
    if(isAdmin())
    {
        $imgName = $_POST['img'];
        $thumbPath= "thumbs/" . $_POST['img'];

        if($_POST['approved'] == "on")
        {
            $imagePath= "images/" . $_POST['img'];

            //Delete image
            chmod($imagePath, 0777); //change permissions
            $deleted = unlink($imagePath); //delete file

            //Delete thumbnail 
            chmod($thumbPath, 0777); //change permissions
            $deleted = unlink($thumbPath); //delete file
            redirect("index.php");

        }
        else
        {
            echo <<<HTML
            <div style="text-align:center;">
            <h1> Are you sure?</h1>
            <img src="$thumbPath" height="20%"/><br />
            $imgName<br /> 
            <form method="post" action="delete.php">
            <input type="checkbox" name="approved" />Yes, I'm positive I will
            <u><b>never</b></u> want this image again.<br />
            <input type="hidden" name="img" value="$imgName" />
            <br />
            <input type="submit" value="Delete" />
            </form>
            </div>

HTML;
        }
    }
    else
        redirect("index.php");

}
else
    redirect("login/");

?>
