<?php
/**
 * This is the vehicle controller
 */
// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicles model
require_once '../model/vehicles-model.php';
// Get the function file
require_once '../library/functions.php';
// Get the upload model
require_once '../model/uploads-model.php';
// Get the array of classifications
$classifications = getClassifications();

/**
 * var_dump is a PHP function that displays information about a variable, 
 * array or object.
 * The exit directive stops all further processing by PHP.
 * Using var_dump and exit are great ways to test and see that what you thought 
 * you were getting is actually what you got!
 */
//var_dump($classifications);
//    exit;

// Build a navigation bar using the $classifications array
/**
 * 1. $navList = '<ul>'; - creates an unordered list as a string and assigns it 
 * to the $navList variable.
 * 2. $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors 
 * home page'>Home</a></li>"; - creates a list item with a link to the controller 
 * at the root of the phpmotors folder as a string. The string is then added to 
 * the value already stored in the variable. That's what the .= operator does, it 
 * adds to a variable.
 * 3. foreach ($classifications as $classification) { - This begins a foreach loop 
 * that will find each of the sub-arrays in the $classifications array and break them 
 * apart, one at a time, and stores each one into a new variable called $classification. 
 * Refer to foreach loops at php.net.
 * 4. $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] 
 * product line'>$classification[classificationName]</a></li>"; - This is a list item with a 
 * link that points to the controller in the phpmotors folder, but this time it is followed by 
 * a question mark (e.g. ?) and then by a key - value pair. The key is action and the value is the 
 * classification name inside of the $classification variable. The $classification['classificationName'] is
 *  inside of a PHP function - urlencode - which takes care of any spaces or other special characters so 
 * they are valid HTML. The whole piece is concatenated into the string as a whole. As with all previous 
 * code in this example, the string is being added to the $navList variable.
 * 5. } - this lone right curly brace closes the foreach loop.
 * 6. $navList .= '</ul>'; - This line closes the unordered list.
 */
/**$navList = '<ul>';
$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
 $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}
$navList .= '</ul>';*/

// Get the array of the classifications
$classifications = getClassifications();
// Build the navigation bar using the $classification array
$navList = getNavBar($classifications);

/**$classificationList = '<select id="carClassification" name="carClassification">';
$classificationList .= '<option selected> Choose a car classification </option>';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'> $classification[classificationName] </option>";
}
$classificationList .= '</select>';*/
//echo $navList;
//exit;

/**
 * By creating and naming the controller index.php all web 
 * traffic that comes to the phpmotors folder will automatically 
 * be directed to the controller.
 */

 /**
  * - $action is a variable that we will use to store the type of content 
  * being requested.
  * - We use the filter_input() function to sift the content to eliminate 
  * code that could do the web site harm (read more on php.net about the 
  * filter_input funtion).
  * - We check the POST object (input from forms) and the GET object (input 
  * from links) to see if there is a "name - value pair (aka key - value pair) 
  * where the key is the word "action". If such a combination is found, the 
  * value is stored in the $action variable.
 */
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
 $action = filter_input(INPUT_GET, 'action');
}

/**
 * - The switch control structure examines the $action variable, to see what it's 
 * value is. 
 * - Each case statement represents a different process to execute. In this instance 
 * the case statement has a meaningless value (e.g. 'something') to check and when 
 * it does not match the value of $action it is ignored. 
 * - However, since the case statement does not execute, the default statement executes 
 * and delivers the home.php view.
 * - If $action had a value and our one case statement had a matching value, then it 
 * would run and the default would be ignored because the "break" statement would 
 * end the switch and the control structure would be exited.
 */
switch ($action){
    //filter and store the data
    case 'add-car-classification':
        $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $checkClassificationName = checkCarClassification($classificationName);
        
        //check for missing data
        if (empty($checkClassificationName)) {
            $message = '<p>Please provide information for all empty fields.</p>';
            //echo $classificationName;
            include '../view/add-classification.php';
            exit;
        }

        // Send the data to the model
        $classOutcome = addClassification($classificationName);

        //Check and report the result
        if ($classOutcome === 1) {
            header('Location: /phpmotors/vehicles/index.php');
            exit;
        } else {
            $message = "<p> Sorry, could not add $classificationName to the classification list.</p>";
            include '..view/vehicles-main.php';
            exit;
        }
        break;
    case 'add-vehicle-info':
        // Filter and store the data
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_ALLOW_FRACTION));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));
        
        $checkInvMake = checkInvMake($invMake);
        $checkInvModel = checkInvModel($invModel);
        $checkInvDescription = checkInvDescription($invDescription);
        $checkInvStock = checkInvStock($invStock);
        $checkInvColor = checkInvColor($invColor);

        // Check for missing data
        if(empty($checkInvMake) || empty($checkInvModel) || empty($checkInvDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($checkInvStock) || empty($checkInvColor)){
            $message = '<p>Please provide information for all empty form fields.</p>';
            //echo $clientFirstname, $clientLastname, $clientEmail, $clientPassword;
            include '../view/add-vehicle.php';
            exit;
        }

        $vehicleOutcome = addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

        // Check and report the result
        if($vehicleOutcome === 1){
            $message = "<p>The $invMake $invModel was successfully added to the inventory. </p>";
            include '../view/add-vehicle.php';
            exit;
        } else {
        $message = "<p>Sorry could not add $invMake $invModel. Please try again.</p>";
        include '../view/add-vehicle.php';
        exit;
        }
        break;
    case 'add-classification':
        include '../view/add-classification.php';
        break;
    case 'add-vehicle':
        include '../view/add-vehicle.php';
        break;    
    /* * ********************************** 
    * Get vehicles by classificationId 
    * Used for starting Update & Delete process 
    * ********************************** */ 
    case 'getInventoryItems': 
        // Get the classificationId 
        // Collects and filters the input of classificationId from the view
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
        // Fetch the vehicles by classificationId from the DB 
        // Uses the classificationId to request an array of vehicles in inventory that belong to that classification
        $inventoryArray = getInventoryByClassification($classificationId); 
        // Convert the array to a JSON object and send it back 
        // Converts the inventory array to a JSON object and returns it to the view. Note the use of echo, not return to send back the JSON object.
        echo json_encode($inventoryArray); 
        break;
    case 'mod':
        // We need to capture the value of the second name - value pair.
        // Remember this is coming from a link, therefore it is a GET request.
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        // We will send the $invId variable into a function that will get the information for that single vehicle.
        $invInfo = getInvItemInfo($invId);
        // We will check to see if $invInfo has any data. If not, we will set an error message.
        if(count($invInfo)<1){
            $message = 'Sorry, no vehicle information could be found.';
        }
        // Finally, we will call a view where the data can be displayed so that the changes can be made to the data.
        include '../view/vehicle-update.php';
        exit;

        break;
    case 'updateVehicle':
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        if (empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
        $message = '<p>Please complete all information for the updated item! Double check the classification of the item.</p>';
        include '../view/vehicle-update.php';
        exit;
        }
        $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
        if ($updateResult) {        
	        $message = "<p class='notify'>Congratulations, the $invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
        	$message = "<p>Error. The updated vehicle was not added.</p>";
        	include '../view/vehicle-update.php';
        	exit;
        }
        break;  
    case 'del':
        // We need to capture the value of the second name - value pair.
        // Remember this is coming from a link, therefore it is a GET request.
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        // We will send the $invId variable into a function that will get the information for that single vehicle.
        $invInfo = getInvItemInfo($invId);
        // We will check to see if $invInfo has any data. If not, we will set an error message.
        if(count($invInfo)<1){
            $message = 'Sorry, no vehicle information could be found.';
        }
        // Finally, we will call a view where the data can be displayed so that the changes can be made to the data.
        include '../view/vehicle-delete.php';
        exit;
        break; 
    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteVehicle($invId);
        if ($deleteResult) {        
	        $message = "<p class='notify'>Congratulations, the $invMake $invModel was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
        	$message = "<p>Error. The updated vehicle was not deleted.</p>";
        	header('location: /phpmotors/vehicles/');
        	exit;
        }
        break;
    case 'classification':
        // Filter, sanitize, and store the second value being sent through URL (recall URL's are automatically sent using "GET")
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Create variable to store the array of vehicles we hope will be returned from the behicles model
        $vehicles = getVehiclesByClassification($classificationName);

        // Built an if - else control structure to see if any vehicles were actually returned or not. If "NO", then an error message will
        // be built. If "YES", then the array of vehicles will be sent to custom function to build the HTML around the vehicles info and
        // return it to us for dislay.
        if(!count($vehicles)){
            $message = "<p class='notice'>Sorry, no $classificationName vehicles could be found.</p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }

        // Finally, call view that will be utilized to display either the message or the vehilces belonging to the car class clicked on in
        // the navigation bar.
        include '../view/classification.php';
        
        break;
    case 'vehicleInfo':
        $invId = filter_input(INPUT_GET, 'vehicleName', FILTER_SANITIZE_NUMBER_INT);
        $vehicleInformation = getVehicleDetails($invId);
        $vehicleThumbnail = getImageThumbnail($invId);

        $thumbnails = buildVehicleThumbnails($vehicleThumbnail);
        
        if (empty($vehicleInformation)){
            $message = "<p class='notice'>Sorry there was a problem retrieving this vehicles information.</p>";
        } else {
            // If not, build the html for the vehicle information
            $vehicleView = buildVehicleView($vehicleInformation);
        }
        include '../view/vehicle-detail.php';
        
        break;
    default:
        $classificationList = buildClassificationList($classifications);
        include '../view/vehicles-main.php';
        break;
}
?>