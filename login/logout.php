<? 
include_once 'display.php';

    // enable sessions
    session_start();

        connect();

    if(isset($_SESSION['token']))
    {
        $sql = sprintf("DELETE FROM session WHERE token='%s'", mysql_real_escape_string($_SESSION["token"]));

        // execute query
        $result = mysql_query($sql);
    }
    elseif(isset($_COOKIE['token']))
    {
        $sql = sprintf("DELETE FROM session WHERE token='%s'", mysql_real_escape_string($_COOKIE["token"]));

        $result = mysql_query($sql);
    }
    else
        $result = FALSE;

    // delete cookies, if any
    setcookie("token", "", time() - 3600);

    // log user out
    setcookie(session_name(), "", time() - 3600);


    session_destroy();

    if($result)
        redirect("index.php");
     else
        echo "Deleteing session failed";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Log Out</title>
  </head>
  <body>
    <h1>You are logged out!</h1>
    <h3><a href="index.php">home</a></h3>
  </body>
</html>
