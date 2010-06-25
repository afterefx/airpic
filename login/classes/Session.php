<?php

class Session
{
    private $_database = new Database();
    private $_sessionID;

    public function __construct()
    {
        // enable sessions
        session_start();
    }

    public function createSession()
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
    }

    public function checkForSession()
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

    public function updateLastSeen()
    {
        $sql = sprintf("UPDATE session SET lastSeen='%s' WHERE token='%s'", time(),
             mysql_real_escape_string($_SESSION["token"]));

        $result = mysql_query($sql);

        if ($result === FALSE)
            die("Could not update time last seen");

        return $result;

    }

    public function deleteSession()
    {

    }

}

?>
