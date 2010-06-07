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
            <a href="http://mobile.afterpeanuts.com/Airpic.apk">prog</a><br />
            <br />
HTML;
            if(isAdmin())
            {
                $content.=<<<HTML
                    <a href="addEntry.php">Add Entry</a><br />
HTML;
            }

            $content.=<<<HTML

            <br />
            <br />
            <a href="logout.php">log out</a>
HTML;
        }
        else
            redirect("login.php");

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
    <h3>
HTML;

    return $content;

}

function bottom()
{
    $content=<<<HTML
    </h3>
    <br />
    <b>Login Demos</b>
    <ul>
      <li><a href="login.php">login</a></li>
    </ul>
  </body>
</html>

HTML;
    return $content;
}

?>
