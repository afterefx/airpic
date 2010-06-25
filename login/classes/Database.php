<?php

class Database
{
    public function connect()
    {
        global $url, $userName, $password, $database;

        if (($connection = mysql_connect($url, $userName, $password)) === FALSE)
            die("Could not connect to database");

        // select database
        if (mysql_select_db($database, $connection) === FALSE)
            die("Could not select database");
    }

    public function query()
    {
        return mysql_query($sql);
    }
}

?>
