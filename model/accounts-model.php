<?php
/**
 * This is the accounts model
 */

 //Register new client
 function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword){
    // Create a new database connection object by calling the phpmotors database connection function from the connections.php file.
    $db = phpmotorsConnect();
    // The SQL statement to be used with the database
    //this is the SQL INSERT statement, but using named parameters instead of actual values as part of the prepared statement.
    $sql = 'INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword)
        VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';
    // Create the prepared statement using the phpmotors connection
    // sends the SQL statement to the database server where it is checked for correctness, and if it is, a PDO Prepared Statement 
    //  object is created and stored into the $stmt variable.
    $stmt = $db->prepare($sql);

    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    // each of these four bindValue functions replaces the name parameter (e.g. :clientFirstname) with the actual value from 
    // the variable (e.g. $clientFirstname). It also tells the database the type of data it is 
    // receiving (e.g. PDO::PARAM_STR), in this case a string.
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    // Insert the data
    // This sends the now complete SQL statement to the server and the data is inserted to the database.
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    // The prepared statement object asks the database server to indicate how many rows changed as a result of the last 
    // SQL query, the number that is returned is stored into the $rowsChanged variable. We anticipate that number being 1, meaning 
    // 1 new record was added to the database.
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    // Closes the interaction between the function and the database server.
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    // Sends the value of the $rowsChanged variable back to wherever the function was called (this should be in the controller)
    return $rowsChanged;
 }

 //Check for an exisiting email address 
 function checkExistingEmail($clientEmail){
    // Create a new database connection object by calling the phpmotors database connection function from the connections.php file.
    $db = phpmotorsConnect();
    // The SQL statement to be used with the database
    // This is the SQL SELECT query to see if a matching email address can be found in the database table.
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';
    // Create the prepared statement using the phpmotors connection
    // sends the SQL statement to the database server where it is checked for correctness, and if it is, a PDO Prepared Statement 
    //  object is created and stored into the $stmt variable.
    $stmt = $db->prepare($sql);

    // The next line will replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    // each of these four bindValue functions replaces the name parameter (e.g. :clientEmail) with the actual value from 
    // the variable (e.g. $clientEmail). It also tells the database the type of data it is 
    // receiving (e.g. PDO::PARAM_STR), in this case a string.
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    // Insert the data
    // This sends the now complete SQL statement to the server and the data is inserted to the database.
    $stmt->execute();
    
    // We only want to get a single row from the database if a match is found, so use a "fetch()" not a "fetchAll()". In addition, we 
    // can indicate that we only want a simple numeric array by adding a parameter to the fetch of "PDO::FETCH_NUM".
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();
    // You can then check if you got back and empty array or not.
    // If the array is empty, return a zero "0". If the array is not empty, return a "1".
    if (empty($matchEmail)) {
        return 0;
    } else {
        return 1;
    }
 }

 //Get client data based on an email address
 function getClient($clientEmail){
    // Create a new database connection object by calling the phpmotors database connection function from the connections.php file.
    $db = phpmotorsConnect();

    // We will extract all of the client data, but not use all of it at once. But, by getting it all, we don't have to make a second 
    // query if our initial check of the password in the controller is successful.
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientEmail = :clientEmail';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();

    // We expect a single record to be returned, thus the use of the fetch() method.
    // To return a simple array using the database field names as the "name" in the "name - value" pair of the client data we pass in the PDO::FETCH_ASSOC parameter.
    // Assuming that you send an email address to the function and a database record with that email is found, the array sent back could look like this:
    // Array ( [clientId] => 14 [clientFirstname] => Bill [clientLastname] => Hickock [clientEmail] => wildbill@ok.com [clientLevel] => 1 [clientPassword] => $2y$10$BhuiPAAubX... )
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
 }

// Update the client information
function updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId){
    // Create a new database connection object by calling the phpmotors database connection function from the connections.php file.
    $db = phpmotorsConnect();
    $sql = 'UPDATE clients SET clientFirstname = :clientFirstname, clientLastname = :clientLastname, clientEmail = :clientEmail WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

// Get new client data
function newClientData($clientId){
    // Create a new database connection object by calling the phpmotors database connection function from the connections.php file.
    $db = phpmotorsConnect();
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword FROM clients WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
}

function updatePassword($hashedPassword, $clientId){
    // Create a new database connection object by calling the phpmotors database connection function from the connections.php file.
    $db = phpmotorsConnect();
    $sql = 'UPDATE clients SET clientPassword = :clientPassword WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientPassword', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
?>