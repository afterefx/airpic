<?php

class auth
{
    private $database = new Database();
    private $session = new Session();
    private $user = new User();

    selectQuery();
    updateQuery();
    insertQuery();
    deleteQuery();


    public function redirect($navigateTo)
    {
        $host = $_SERVER["HTTP_HOST"];
        $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
        $goto = sprintf("Location: http://%s%s/%s", $host, $path, $navigateTo);
        header($goto);
    }

}

?>
