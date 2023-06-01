<?php
    /**
     * Proxy connection to the phpmotors database.
     */

function phpmotorsConnect(){
     /**
      * We will need four pieces of information:
      * 1. Server Name
      * 2. Database Name
      * 3. Proxy Username
      * 4. Proxy User Password
      * In addition we will need to know the type of 
      * database to which you are connecting
      */
    //Server name
    $server = 'localhost';
    //Database name
    $dbname = 'phpmotors';
    //Proxy username
    $username = 'iClient';
    //Proxy user password
    $password = '3kep8N0u0AvDb0N!';
    //the DSN indicates the type of database being 
    //connected to - in this case a MySQL database as 
    //indicated in the code
    $dsn = "mysql:host=$server;dbname=$dbname";
    //Error handling mechanism added as an array with a
    //key and value stored into a variable
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    
    //Now we will use a "try - catch" block to build the
    //connection. If it succeeds, a connection is created
    //and returned. If it fails, the catch block will handle
    //the error.
    try {
        $link = new PDO($dsn, $username, $password, $options);
        return $link;
        /**if (is_object($link)) {
            echo 'It worked!';
        }*/
    } catch (PDOException $e) {
        header('Location: /phpmotors/view/500.php');
        exit;
        //echo "It didn't work, error: " . $e->getMessage();
    }
}
// Function call:
phpmotorsConnect();

    
?>