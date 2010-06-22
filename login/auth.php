<?php
include_once 'display.php';

    // enable sessions
    session_start();

    connect();

    $result = checkForSession();

    //check for authenticated sessions
    if($result)
        redirect("index.php");

    // if username and password were submitted, check them
    if (isset($_POST["user"]) && isset($_POST["pass"]))
    {
        $userpassword = hash("sha512",$_POST["pass"]);

        // prepare SQL
        $sql = sprintf("SELECT 1 FROM users WHERE user='%s' AND pass='%s'",
                       mysql_real_escape_string($_POST["user"]),
                       mysql_real_escape_string($userpassword));

        // execute query
        $result = mysql_query($sql);
        if ($result === FALSE)
            die("Could not query database");

        // check whether we found a row
        if (mysql_num_rows($result) == 1)
        {

            //create a token
             mt_srand();
                $number = mt_rand();
            $token = hash("sha512",$number);

            //add token to database and assign to user
            $sql = sprintf("INSERT INTO session values ('%s', '%s', '%s', '%s')", $token, $_POST["user"], time(), time());
            $result = mysql_query($sql);
            $_SESSION['token'] = $token;
            if(isset($_POST["remember"]) && $_POST["remember"] == "true")
                setcookie("token", $token, time() + 14 * 24 * 60 * 60);

            if(isset($_POST["redirect"]))
                header("Location: " . $_POST["redirect"]);
            else 
                redirect("index.php");
            exit;
        }
        else
        {
            header("Location: http://www.reddit.com/");       
        }

    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Log In</title>
  </head>
  <body>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
    <?php
    if(isset($_GET["page"]) && $_GET["page"] != '')
{
    $input = '<input name="redirect" type="hidden" value="';
    $input .= $_GET["page"];
    $input .= '">';

    echo $input;
} ?>
      
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
          <td style="text-align:right"><input name="remember" type="checkbox" value="true"/></td>
          <td>Remember me <input type="submit" value="Log In" /></td>
        </tr>
      </table>      
    </form>
  </body>
</html>
