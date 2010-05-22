<? 
    // enable sessions
    session_start();
    $content=top();

    if ($_SESSION["authenticated"]) 
    { 

    $content.=<<<HTML
        You are logged in!  
        <br />
        <a href="logout.php">log out</a>
HTML;
    } 

    else 
    { 

//need to redirect to login page here
    $content.=<<<HTML
        You are not logged in!
HTML;
    header("Location: login.php");
    } 

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
      <li><a href="login1.php">version 1</a></li>
      <li><a href="login2.php">version 2</a></li>
      <li><a href="login3.php">version 3</a></li>
      <li><a href="login4.php">version 4</a></li>
    </ul>
  </body>
</html>

HTML;
    return $content;
}
?>

