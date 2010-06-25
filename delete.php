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
            <img src="$thumbPath" height="20%"/>
            <form method="post" action="delete.php">
            <input type="checkbox" name="approved" />Yes<br />
            <input type="hidden" name="img" value="$imgName" />
            <input type="submit" value="Delete" />
            </form>

HTML;
        }
    }
    else
        redirect("index.php");

}
else
    redirect("login/");

?>
