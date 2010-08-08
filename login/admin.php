<?php
include_once 'display.php';

session_start();

connect();

$result = checkForSession();

if($result && isAdmin())
{
    //display the images
    echo "Current sessions <br />";
    echo "Users <br />";
}    
else
    echo "GO AWAY!";

?>
