<?php

function connect()
{
    global $url, $userName, $password, $database;

      if (($connection = mysql_connect($url, $userName, $password)) === FALSE)
                  die("Could not connect to database");

          // select database
          if (mysql_select_db($database, $connection) === FALSE)
                      die("Could not select database");
}

function redirect($navigateTo)
{
    $host = $_SERVER["HTTP_HOST"];
    $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    $goto = sprintf("Location: http://%s%s/%s", $host, $path, $navigateTo);
    header($goto);
}

function generateApiKey()
{
    mt_srand();
    $number = mt_rand()+time();
    $temp = hash("sha512",$number);
    return substr($temp, 0, 40);
}

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
            updateLastSeen();
            return true;
        }
    }
    else
        return false;

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

