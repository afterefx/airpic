<?php

function checkForSession()
{
    
    if(isset($_SESSION["token"]))
    {
        //check if session is still valid
        $sql = sprintf("SELECT 1 FROM session WHERE token='%s'",
        mysql_real_escape_string($_SESSION["token"]));
    
        // execute query
        $result = mysql_query($sql);
        if ($result === FALSE)
            die("Could not query database");
        else
        {
            updateLastSeen();
            return true;
        }
    }
    elseif(isset($_COOKIE["token"]))
    {
        //check if session is still valid
        $sql = sprintf("SELECT 1 FROM session WHERE token='%s'",
        mysql_real_escape_string($_COOKIE["token"]));

        $result = mysql_query($sql);
        if($result === FALSE)
            die("Could nto query database");
        else
        {
            $_SESSION['token'] = $_COOKIE['token'];
            updateLastSeen();
            return true;
        }
    }
    else
        return false;

}

function connect()
{
    global $url, $userName, $password, $database;

      if (($connection = mysql_connect($url, $userName, $password)) === FALSE)
                  die("Could not connect to database");

          // select database
          if (mysql_select_db($database, $connection) === FALSE)
                      die("Could not select database");
}

function generateApiKey()
{
    mt_srand();
    $number = mt_rand()+time();
    $temp = hash("sha512",$number);
    return substr($temp, 0, 40);
}

function getUserName()
{
    if(isset($_SESSION["token"]))
    {
        $getUserSQL = sprintf("SELECT user FROM session WHERE token='%s'",
            mysql_real_escape_string($_SESSION["token"]));
    
        $result = mysql_query($getUserSQL);
    
        $row = mysql_fetch_array($result);
        return $row['user'];
    }
    elseif(isset($_COOKIE["token"]))
    {

        $getUserSQL = sprintf("SELECT user FROM session WHERE token='%s'",
            mysql_real_escape_string($_COOKIE["token"]));

        $result = mysql_query($getUserSQL);

        $row = mysql_fetch_array($result);
        return $row['user'];
    }
}

function getName()
{
    $user = getUserName();
    
    $sql = sprintf("SELECT fname FROM users WHERE user='%s'", $user);
    $result = mysql_query($sql);

    $row = mysql_fetch_array($result);

    return $row['fname'];
}


function isAdmin()
{
    $user = getUserName();
    
    $sql = sprintf("SELECT isAdmin FROM users WHERE user='%s'", $user);
    $result = mysql_query($sql);

    $row = mysql_fetch_array($result);

    if($row['isAdmin'])
        return true;
    else
        return false;
}

function redirect($navigateTo)
{
    $host = $_SERVER["HTTP_HOST"];
    $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    $goto = sprintf("Location: http://%s%s/%s", $host, $path, $navigateTo);
    header($goto);
}

function updateLastSeen()
{
    $sql = sprintf("UPDATE session SET lastSeen='%s' WHERE token='%s'", time(),
         mysql_real_escape_string($_SESSION["token"]));

    $result = mysql_query($sql);

    if ($result === FALSE)
        die("Could not update time last seen");

}

?>

