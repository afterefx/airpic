<?php

include_once 'display.php';

    // enable sessions
    session_start();

    connect();

    $result = checkForSession();

    if(isAdmin())
    {
        top();
        if($result)
        {
            if (isset($_POST["user"]) 
                && isset($_POST["pass"])
                && isset($_POST["email"]))
            {
                //encrypt password
                $userpass = hash("sha512", $_POST["pass"]);

                if($_POST["isAdmin"] == "on")
                    $setAdmin=1;
                else
                    $setAdmin=0;

                // prepare SQL
                $sql = sprintf("INSERT INTO users (user, pass, fname, email,
                    isAdmin, created, modifiedBy) VALUES ('%s', '%s', '%s',
                        '%s', '%s', '%s', '%s')",
                           mysql_real_escape_string($_POST["user"]),
                           mysql_real_escape_string($userpass),
                           mysql_real_escape_string($_POST['fname']),
                           mysql_real_escape_string($_POST["email"]),
                           $setAdmin,
                           time(),
                           mysql_real_escape_string("chris"));


                // execute query
                $result = mysql_query($sql);
                if ($result === FALSE)
                    die("Could not insert into database");

                if($result)
                {
                    echo "SUCCESS! " .  $_POST['fname'] ." was added to the user database.<br />";
                }
                else
                    echo "Failure";
            }
        }
        else
            redirect("auth.php");
    }
    else
        redirect("index.php");


function top()
{
    echo<<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Add Entry</title>
  </head>
  <body>
HTML;
}

?>

    <form action="<? echo $_SERVER["PHP_SELF"]; ?>" method="post">
      <table>
        <tr>
          <td>Username:</td>
          <td>
            <input name="user" type="text" /></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><input name="pass" type="password" /></td>
        </tr>
        <tr>
          <td>First Name:</td>
          <td><input name="fname" type="text" /></td>
        </tr>
        <tr>
          <td>Email:</td>
          <td><input name="email" type="text" /></td>
        </tr>
       <tr>
         <td>Admin: </td>
         <td><input name="isAdmin" type="checkbox" /></td>
       </tr>
       <tr>
          <td></td>
          <td><input type="submit" value="Add Entry" /></td>
        </tr>
      </table>      
    </form>
    <br />
    <br />
    <br />
    <a href="index.php">Home</a>
    <br />
    <br />
    <a href="logout.php">Logout</a>
    <br />
  </body>
</html>






