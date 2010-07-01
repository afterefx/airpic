<?php
include_once 'login/display.php';

session_start();
connect();

$user = $_POST['username']; 

$sql = sprintf("SELECT * FROM apikeys WHERE username='%s'", mysql_real_escape_string($user));
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

if($row['key'] == $_POST['key'])
{ 
    if(isset($_POST['img']))
    {

        echo "<h1>Set</h1><br />";
        //get current time
        $dateTime = date('Y.m.d.H.i.s', (time()+60*60*2));
        //open a file handle
        $newfile = "images/" . $dateTime . ".jpg";
        $newhandle = fopen($newfile, "w");
        //decode string sent
        $towrite = base64_decode($_POST['img']);
        //write to file
        $bytes = fwrite($newhandle, $towrite);
        //close handle
        fclose($newhandle);
    }
}

?>
