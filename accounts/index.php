<?php
/**
 * This is the Account Controller
 */
//Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions file
require_once '../library/functions.php';

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
    case 'update':
      // deliver the client-update.php view
      include '../view/client-update.php';
      break;
    case 'updateInfo':
      // Filter and collect the inputs
      $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
      $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

      // Check if the email address is different than the one in the session. 
      $existingEmail = checkExistingEmail($clientEmail);
      // If yes, check that the new email address does not already exist in the clients table.
      if ($existingEmail) {
        $message = '<p class="notice"> That email address already exists. Do you want to login instead? </p>';
        include '../view/client-update.php';
        exit;
      }
      // Check for errors.
      // Return data to the client-update view for correction if errors are found.
      if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
        $message = '<p>Please provide information for all empty form fields.</p>';
        //echo $clientFirstname, $clientLastname, $clientEmail, $clientPassword;
        include '../view/client-update.php';
        exit;
      }
      // Process the update 
      $updateResult = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);

      // Query the client data from the database, based on the clientId
      $clientData = newClientData($clientId);
      array_pop($clientData);
      $_SESSION['clientData'] = $clientData;

      // Set a success or failure message and store it in the session
      if ($updateResult) {   
        $message = "<p class='notify'>Congratulations $clientFirstname, your information was successfully updated.</p>";
          $_SESSION['message'] = $message;
          header('location: /phpmotors/accounts/');
          exit;
      } else {
        $message = "<p>Error. The updated failed.</p>";
        include '../view/client-update.php';
        exit;
      }
      break;
    case 'updatePassword':
      // Collect and filter the new password      
      $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
      $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

      $checkPassword = checkPassword($clientPassword);

      // Check for missing data
      if(empty($checkPassword)){
        $message = '<p>Please provide information for all empty form fields.</p>';
        //echo $clientFirstname, $clientLastname, $clientEmail, $clientPassword;
        include '../view/client-update.php';
        exit;
      }

      $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

      $updateResult = updatePassword($hashedPassword, $clientId);

      // Set a success or failure message and store it in the session
      if ($updateResult) {   
        $message = "<p class='notify'>Congratulations, password was successfully updated.</p>";
          $_SESSION['message'] = $message;
          header('location: /phpmotors/accounts/');
          exit;
      } else {
        $message = "<p>Error. The password updated failed.</p>";
        include '../view/client-update.php';
        exit;
      }


      break;
    case 'register':
      // Filter and store the data
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

      //A new variable that will call the new function, sending the $clientEmail variable into the function as a parameter.
      $existingEmail = checkExistingEmail($clientEmail);

      // Checking for an exisiting email address.
      // This check will occur before the other data checks because if the email already exists, there is no need to continue with
      // the registration process. Thus, we do this check first.
      // The if() control structure always results in being "TRUE" or "FALSE". By checking to see if the value of the new variable is 
      // TRUE (again, remember that the number "1" is equivalent of TRUE) then the email exists and we set the message and bring 
      // in the login view.
      // If the if() is FALSE, then we go ahead and conduct the other data checks as part of the regular registration process.
      if ($existingEmail) {
        $message = '<p class="notice"> That email address already exists. Do you want to login instead? </p>';
        include '../view/login.php';
        exit;
      }

    
      // Check for missing data
      if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
        $message = '<p>Please provide information for all empty form fields.</p>';
        //echo $clientFirstname, $clientLastname, $clientEmail, $clientPassword;
        include '../view/registration.php';
        exit;
      }

      /**
       * Placing the hash code after the validation section of our registration process, we know that the password stored in the
       * $clientPassword variable meets all of the requirement.
       * The plain password is sent to the password_hash() function, it is hashed, the hash is returned, and it is stored into 
       * the $hashedPassword variable.
       * The password_hash() function can be gien muliple parameters to change the way it performs the hash, but the recommended
       * parameter is PASSWORD_DEFAULT.
       * Finally, the now hashed password will be sent to the DB for storage and should no longer be human readable.
       */

      $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
    
      // Send the data to the model
      $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
    
      // Check and report the result
      if($regOutcome === 1){
        setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
        //$message = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
        $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
        // include() acts as a forward, simply including the view and retaining all the POST data from the form.
        // When retaining POST data, you can inadvertently cause duplication in your database, which can result in data 
        // integrity issues. This may not be a problem for product data, but is a problem for client accounts when an 
        // email address must be unique.
        //include '../view/login.php';
        // header() acts as a redirect, requiring the server to reload and removing all POST data from the form.
        header('Location: /phpmotors/accounts/?action=login');
        exit;
      } else {
       $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
        include '../view/registration.php';
        exit;
      }
          break;
    case 'login':
      // Filter and store the data
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        // The checkEmail() function sanitizes the email string and then validates that it is a valid email. If it is, 
        // the valid email is returned, but if not "NULL" is returned.
        $clientEmail = checkEmail($clientEmail);
        // The checkPassword() function checks that the password meets the requirements for our password and 
        // returns a "1" if it does or a "0" if it doesn't.
        $checkPassword = checkPassword($clientPassword);
    
      // Check for missing data
      // We then run basic checks on the variables and if errors are found, the login.php view is 
      // included so the errors can be fixed.
      if(empty($clientEmail) || empty($clientPassword)){
        $message = '<p>Please provide information for all empty form fields.</p>';
        //echo $clientEmail, $clientPassword;
        include '../view/login.php';
        exit;
      }

      // A valid password exists, proceed with the login process
      // Query the client data based on the email address
      // If no errors are found, the potential matching client data is queried from the database using the 
      // submitted email address.
      $clientData = getClient($clientEmail);

      // Compare the password just submitted against
      // the hashed password for the matching client
      // When the password was stored in the database it was hashed using the password_hash() function. Since the 
      // hash cannot be "un hashed" we have to use a different PHP function to hash the new password and compare the 
      // two hashes to see if they match.
      // The password_verify function has the ability to hash the new password using the same information as when the 
      // original password was hashed, but using the new password. If the passwords were the same, the hashes should match and 
      // we know that we have a valid login. The results of this check are stored into $hashCheck.
      $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
      
      // If the hashes don't match create an error
      // and return to the login view
      // In the event that the hashed passwords do not match ($hashCheck is FALSE) we report back to the client using an 
      // error message in the login.php view.
      if(!$hashCheck) {
        $message = '<p class="notice">Please check your password and try again.</p>';
        include '../view/login.php';
        exit;
      }
      /**
       * If the $hashCheck is not FALSE, the we have a valid email and password and the clientData is good to go. We now login the site visitor by:
       * 1. Creating a "flag" in the session named "loggedin" with a value of TRUE.
       * 2. We remove the password from the $clientData array using the PHP array_pop() function.
       * 3. We then store the $clientData array into the session using the same name "clientData" so we can use it when needed.
       * 4. Finally, we send the logged in site visitor to the admin.php view (this view will be created as part of the enhancement).
       */

      // A valid user exists, log them in
      $_SESSION['loggedin'] = TRUE;
      // Remove the password from the array
      // the array_pop function removes the last
      // element from an array
      array_pop($clientData);
      // Store the array into the session
      $_SESSION['clientData'] = $clientData;
      // Send them to the admin view
      include '../view/admin.php';
      exit;
          break;
    case 'logout':
      // If a "Logout" is received then the session data should be unset (hint, hint) and the session destroyed (hint, hint) and the 
      // client is returned to the main phpmotors controller.
      session_unset();
      session_destroy();
      header('Location: ../index.php');
      break;
    case 'signup':
        include '../view/registration.php';
     break;
    default:
        include '../view/admin.php';
}
?>