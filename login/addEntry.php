<?
    /**
     * login6.php
     *
     * A simple login module that checks a username and password
     * against a MySQL table with no encryption by asking for a binary answer.
     *
     * David J. Malan
     * Computer Science E-75
     * Harvard Extension School
     */

include_once 'databaseSettings.php';

    // enable sessions
    session_start();

    // connect to database
    //trustedpeople
    if (($connection = mysql_connect($url, $userName, $password)) === FALSE)
        die("Could not connect to database");

    // select database
    if (mysql_select_db($database, $connection) === FALSE)
        die("Could not select database");

    // if username and password were submitted, check them
    if (isset($_POST["user"]) && isset($_POST["pass"]))
    {
        //encrypt password
        $userpass = hash("sha512", $_POST["pass"]);

        // prepare SQL
        $sql = sprintf("INSERT INTO users (user, pass, email) VALUES ('%s', '%s', '%s')",
                       mysql_real_escape_string($_POST["user"]),
                       mysql_real_escape_string($userpass)
                       mysql_real_escape_string($_POST["email"]));

        // execute query
        $result = mysql_query($sql);
        if ($result === FALSE)
            die("Could not insert into database");

        if($result)
        {
            echo "SUCCESS!";
            header("Location: index.php");
        }
        else
            echo "Failure";


    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Add Entry</title>
  </head>
  <body>
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
          <td>Email:</td>
          <td><input name="email" type="text" /></td>
        </tr>
       <tr>
          <td></td>
          <td><input type="submit" value="Add Entry" /></td>
        </tr>
      </table>      
    </form>
  </body>
</html>
