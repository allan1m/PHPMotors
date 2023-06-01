<?php
/** 
 * This is the Main controller 
 */
//Create or access a Session
session_start();

// Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';
// Get the functions file
require_once 'library/functions.php';

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

 // Check if the firstname cookie exists, get its value
if(isset($_COOKIE['firstname'])){
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}
switch ($action){
    case 'template':
     include 'view/template.php';
     break;    
    default:
     include 'view/home.php';
}

?>