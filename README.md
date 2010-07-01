AIRPIC
==============================

Goals
------------
* Ease of use
* Simple interface
* Admin controls
* Privacy 

To Do
------
* add mysql for image storing or location of images associated with account.  (dont' know which one yet)
* find a way to remove old sessions in case a cookie deletes itself after 2 weeks
    * when an user logs in delete any other sessions that they have already in the session database


* on index.php
    * for admins
        * add a refresh thumbnails for admin only link
        * add a link below each picture that will delete images
    * add a account page for all users (management)

* add uploader php file
    * <strike>base64</strike>
    * via post
    * receives xml formatted document with api key and data to be stored.
        * later in development maybe add gps location and time taken.

* add personalSettings.php page
    * check for a session
    * if user is logged in then query the database for username and other settings
        * apikey
        * email
    * user should be able to 
        * update
            * email
            * password
        * regenerate api key - this should be it's own form that when click it is a submit button that regenerates an api key for the user and displays it plus makes an entry into the database  (can be added for appearence but since apikey has not been implemented yet {when creating an user} this should not be created yet)
    * when user submits
        * only fields that are not empty should be used to be added to the query
        * also make sure to specify who is modifing and give a timestamp for the modification time.
        * query will be performed and a result of the query will come back
        * a results message of success or failure should be shown along with what was changed.

* add userList.php page
  * should check to see if user is admin
  * if user is admin then list all users
      * shows id,username,email, isAdmin checkbox, date created, last modified date, modified by, and apikey
      * there will be buttons next to each user to delete the user or to edit the user
          * when the edit user button is clicked the userid will be sent via _GET
  * on the user page the admin will be able to 
      * edit the username
      * update the password
      * edit the email address
      * regenerate an apikey

* on addEntry.php
  * check if user already exists (put to all lower first)
  * add javascript to check format of email
  * generate api key

* later add activation to website for user accounts
    * generate a random token for activation and add that to a waiting to be activated table
    * send an email to the email on file with a url that has the token (_GET)
        * need to figure out how to automate sending emails
    * once the url is visited with the valid token (sent via GET) the account will make the active field TRUE in user database (this should be checked when checking if user can login and also if session is still valid [that last one is a maybe]) and remove the entry from the waiting to be activated table.
    * there should be a way to remove old waiting to be activated users after 2 weeks.

Phone
-----
* once website uploader is done implement a way to send a picture via POST
* while authenticating to the server
* thinking that this can be done using a RESTful post sending both an api key and the data to be uploaded in an xml format. the data for the image would be in base64...(this is only an idea)

Login
-----
* increment # of login attempts each failed login
* if failed login attempts is >=4 then lock account 
