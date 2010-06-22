<?php

include_once 'display.php';

    // enable sessions
    session_start();
    $content=top();

        connect();

        $result = checkForSession();

        if($result)
        {
            $name = getName();
            $content.=<<<HTML
            Hello $name!  <br />
            <b>Links</b>
            <ul>
            <li><a href="http://mobile.afterpeanuts.com/Airpic.apk">android program</a></li>
            <li><a href="http://mobile.afterpeanuts.com/">main site</a></li>
HTML;
            if(isAdmin())
            {
                $content.=<<<HTML
            <li><a href="addEntry.php">Add Entry</a></li>
HTML;
            }

            $content.=<<<HTML
                <br />
            <li><a href="logout.php">log out</a></li>
            </ul>
HTML;
        }
        else
            redirect("auth.php");

    $content.=bottom();

    echo $content;

//===================================
function top()
{
    $content=<<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Home</title>
  </head>
  <body>
    <h1>Home</h1>
HTML;

    return $content;

}

function bottom()
{
    $content=<<<HTML
  </body>
</html>

HTML;
    return $content;
}

?>
