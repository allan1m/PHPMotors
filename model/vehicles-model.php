<?php 
/**
 * This is the vehicles model
 */

 //Add new car classification
 function addClassification($classificationName){
    // Create a new database connection object by calling the phpmotors database connection function from the connections.php file.
    $db = phpmotorsConnect();
    // The SQL statement to be used with the database
    //this is the SQL INSERT statement, but using named parameters instead of actual values as part of the prepared statement. 
    $sql = 'INSERT INTO carClassification (classificationName)
        VALUES (:classificationName)';
    // Create the prepared statement using the phpmotors connection
    // sends the SQL statement to the database server where it is checked for correctness, and if it is, a PDO Prepared Statement 
    //  object is created and stored into the $stmt variable.
    $stmt = $db->prepare($sql);
    // The next line replaces the placeholders in the SQL
    // statement with the actual value in the variable
    // and tells the database the type of data it is
    // the bindValue functions replace the name parameter (e.g. :classificationName) with the actual value from 
    // the variable (e.g. $classificationName). It also tells the database the type of data it is 
    // receiving (e.g. PDO::PARAM_STR), in this case a string.
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
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

function addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId){
    // Create a new database connection object by calling the phpmotors database connection function from the connections.php file.
    $db = phpmotorsConnect();
    // The SQL statement to be used with the database
    //this is the SQL INSERT statement, but using named parameters instead of actual values as part of the prepared statement. 
    $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId)
        VALUES (:invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invColor, :classificationId)';
    // Create the prepared statement using the phpmotors connection
    // sends the SQL statement to the database server where it is checked for correctness, and if it is, a PDO Prepared Statement 
    //  object is created and stored into the $stmt variable.
    $stmt = $db->prepare($sql);
    // The next line replaces the placeholders in the SQL
    // statement with the actual value in the variable
    // and tells the database the type of data it is
    // the bindValue functions replace the name parameter (e.g. :classificationName) with the actual value from 
    // the variable (e.g. $classificationName). It also tells the database the type of data it is 
    // receiving (e.g. PDO::PARAM_STR), in this case a string.
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
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

// Get vehicles by classificationId 
// Declare the function and the required parameter - which is a classificationId
function getInventoryByClassification($classificationId){ 
    // Call the database connection
    $db = phpmotorsConnect(); 
    // The SQL statement to query all inventory from the inventory table with a classificationId that matches the value 
    // passed in through the parameter.
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
    // Create the PDO prepared statement
    $stmt = $db->prepare($sql); 
    // Replace the named placeholder with the actual value as an integer.
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    // Run the prepared statement with the actual value.
    $stmt->execute();
    // Requests a multi-dimensional array of the vehicles as an associative array, stores the array in a variable.
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    // Close the database connection.
    $stmt->closeCursor(); 
    // Return the array
    return $inventory; 
   }

// Get vehicle information by invId (vehicle ID)
function getInvItemInfo($invId){
    // Call the database connection
    $db = phpmotorsConnect();
    // The SQL statement to query all inventory from the inventory table with a classificationId that matches the value
    // passed in through the parameter
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    // Create the PDO prepared statement
    $stmt = $db->prepare($sql);
    // Replace the named placeholder with the actual value as an integer
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    // Run the prepared statement with the actual value
    $stmt->execute();
    // Request mult-dimensional array of the vehicles as an associative array, stores the array in a variable.
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    // Close the database connection
    $stmt->closeCursor();
    // Return the array
    return $invInfo;
   }

   function updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId){
    // Create a new database connection object by calling the phpmotors database connection function from the connections.php file.
    $db = phpmotorsConnect();
    $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, invDescription = :invDescription, invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invColor = :invColor, classificationId = :classificationId WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
    }

    function deleteVehicle($invId){
        // Create a new database connection object by calling the phpmotors database connection function from the connections.php file.
        $db = phpmotorsConnect();
        $sql = 'DELETE FROM inventory WHERE invId = :invId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
        $stmt->execute();
        $rowsChanged = $stmt->rowCount();
        $stmt->closeCursor();
        return $rowsChanged;
    }

    // This function will get a list of vehicles based on the classification
    function getVehiclesByClassification($classificationName){
        $db = phpmotorsConnect();
        // $sql = 'SELECT * FROM inventory WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName)';
        $sql = "SELECT * FROM inventory AS inv JOIN images AS img ON img.invId = inv.invId WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName) AND img.imgName LIKE '%-tn%' AND img.imgPrimary = 1";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
        $stmt->execute();
        $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $vehicles;
    }

    // This function will get the 
    function getVehicleDetails($invId){
        $db = phpmotorsConnect();
        // $sql = 'SELECT invMake, invModel, invDescription, invPrice, invStock, invColor, invImage, invThumbnail FROM inventory WHERE invId = :invId';
        $sql = 'SELECT inv.invMake, inv.invModel, inv.invDescription, inv.invPrice, inv.invStock, inv.invColor, (SELECT img.imgPath FROM images img WHERE inv.invId = img.invId AND img.imgPrimary = 1 LIMIT 1) invImage FROM inventory inv WHERE invId = :invId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
        $stmt->execute();
        $vehicleInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $vehicleInfo;
    }    

    // Get information for all vehicles
    function getVehicles(){
    	$db = phpmotorsConnect();
    	$sql = 'SELECT invId, invMake, invModel FROM inventory';
    	$stmt = $db->prepare($sql);
    	$stmt->execute();
    	$invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    	$stmt->closeCursor();
    	return $invInfo;
    }
?>