<?php

class User
{
    private $_database = new Database();
    private $_session = new Session();

    private $userID;
    private $userName;
    private $isAdmin;
    private $userFname;
    private $userEmail;
    private $apiKey;


    public function __constructor()
    {

        //check for session

        //if set query all info

        //if not set redirect to login page
    }

    public function getUserID()
    { 
        if(isset($this->userID)
            return $this->userID;
        else
        {
            $user = getUserName();
    
            $sql = sprintf("SELECT userid FROM users WHERE user='%s'", $user);
            $result = $_database->query($sql);

            $row = mysql_fetch_array($result);

            $this->userID = $row['userid'];

            return $this->userID;
        }
    }
         
    public function getUserName();
    public function setUserName($userName);
    public function getAdmin();
    public function setAdmin();
    public function getUserFname();
    public function setUserFname();
    public function getUserEmail();
    public function setUserEmail();
    public function checkPassword();
    public function setPassword();
    public function getAPIKey();
    public function createAPIKey();
    public function addUser();
    public function deleteUser();
    public function loginUser();

?>
