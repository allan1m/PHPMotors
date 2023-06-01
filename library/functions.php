 <?php 
/**
 * This file will become a library of custom functions that we will use in our code to perform a variety of tasks.
 */

 /**
  * Created a function that will build the navigation bar.
  * 1. It will receieve the $carClassifications array as a parameter
  * 2. It will build the navigation in HTMLaround the values found in the $carclassifications array.
  * 3. It will return a string varible holding the HTML navigation list to wherever called.
  */
 function getNavBar($classifications){
  $navList = '<ul>';
  $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
  foreach ($classifications as $classification) {
  $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a></li>";
  }
  $navList .= '</ul>';

  return $navList;
 }

 /**
  * We will add the code to check the email entered. The end result will be returned. It will be one of 
  * two values: 1) The actual email address will be returned if it is judged to be "valid", or 2) NULL - indicating 
  * the email does not appear to be a valid address.
  */
  function checkEmail($clientEmail){
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
  }

  /**
   * We will add the code to check the password entered. Check the password for a minimum of 8 characters,
   * at least one 1 capital letter, at least 1 number, and at least 1 special character.
   * Regular expression patterns are written between forward slashes, e.g., '/ /'.
   * The circumflex symbol, e.g., ^, marks the beginning of a pattern.
   * The open and closing parenthesis, e.g., (), indicate a character class.
   * The question mark, e.g., ?, will match the preceding pattern zero or more times.
   * The period mark, e.g., ., will match any single character.
   * The asterisk, e.g., *, will match the preceding pattern zero or more times.
   * The squar brackets, e.g., [], matches any single character inside it.
   * The curly braces, e.g., {}, is used to match exact character counts.
   * The dollar sign, e.g., $, marks the end of a search pattern.
   * 
   */
  function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword); 
  }

  /**
   * We will add the code to check the password entered. Check the password for a maximum of 30 characters
   * and letters only.
   */
  function checkCarClassification($classificationName){
    $pattern = '/^(?=.*[a-zA-Z])(?:.{1,30})$/';
    return preg_match($pattern, $classificationName);
  }

  function checkInvMake($invMake){
    $pattern = '/^(?=.*[a-zA-Z])(?:.{1,30})$/';
    return preg_match($pattern, $invMake);
  }

  
  function checkInvModel($invModel){
    $pattern = '/^(?=.*[a-zA-Z])(?:.{1,30})$/';
    return preg_match($pattern, $invModel);
  }

  function checkInvDescription($invDescription){
    $pattern = '/^(?=.*[a-zA-Z])(?:.{1,200})$/';
    return preg_match($pattern, $invDescription);
  }

  function checkInvStock($invStock){
    $pattern = '/^(?=.*[[:digit:]])(?:.{0,6})$/';
    return preg_match($pattern, $invStock);
  }

  function checkInvColor($invColor){
    $pattern = '/^(?=.*[a-zA-Z])(?:.{1,30})$/';
    return preg_match($pattern, $invColor);
  }

  // Build the classifications select list 
  // Declare the function and specificy the parameter - an array of classifications
  function buildClassificationList($classifications){ 
    // Begins the select element.
    $classificationList = '<select name="classificationId"q id="classificationList">'; 
    // Create a default option with no value.
    $classificationList .= "<option>Choose a Classification</option>"; 
    // A foreach loop to create a new option for each element within the array.
    foreach ($classifications as $classification) { 
      $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
    } 
    // End the select element.
    $classificationList .= '</select>'; 
    // Returns the finished select element that has been stored into the variable.
    return $classificationList; 
  }

  //This function will build a display of vehicles within an unordered list.
  function buildVehiclesDisplay($vehicles){
    $dv = '<ul id="inv-display">';
    foreach ($vehicles as $vehicle) {
     $dv .= '<li>';
     $dv .= "<a href ='../vehicles/index.php?action=vehicleInfo&vehicleName=$vehicle[invId]'>";
     $dv .= "<img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
     $dv .= '<hr>';
     $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
     $dv .= "<span>$vehicle[invPrice]</span>";
     $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
   }

   function buildVehicleView($vehicleInformation){
    $dv = "<section class = 'car-info'>";
    $dv .= "<img src='$vehicleInformation[invImage]' alt='$vehicleInformation[invMake]-$vehicleInformation[invModel]'>";
    $dv .= '<h2>Price: $'.number_format($vehicleInformation['invPrice']).'</h2>';
    $dv .= "<h2>$vehicleInformation[invMake] $vehicleInformation[invModel] Details</h2>";
    $dv .= "<p>$vehicleInformation[invDescription]</p>";
    $dv .= "<p>Color: $vehicleInformation[invColor]</p>";
    $dv .= "<p>Number in Stock: $vehicleInformation[invStock]</p>";
    $dv .= '</section>';
    return $dv;
   }
    
   /* * ********************************
  *  Functions for working with images
  * ********************************* */
  
  // Adds "-tn" designation to file name
  function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
   }

  // Build images display for image management view
  function buildImageDisplay($imageArray) {
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
     $id .= '<li>';
     $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
     $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
     $id .= '</li>';
   }
    $id .= '</ul>';
    return $id;
   }

  // Build the vehicles select list
  function buildVehiclesSelect($vehicles) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
     $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
   }

  // Handles the file upload process and returns the path
  // The file path is stored into the database
  function uploadFile($name) {
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
     // Gets the actual file name
     $filename = $_FILES[$name]['name'];
     if (empty($filename)) {
      return;
     }
    // Get the file from the temp folder on the server
    $source = $_FILES[$name]['tmp_name'];
    // Sets the new path - images folder in this directory
    $target = $image_dir_path . '/' . $filename;
    // Moves the file to the target folder
    move_uploaded_file($source, $target);
    // Send file for further processing
    processImage($image_dir_path, $filename);
    // Sets the path for the image for Database storage
    $filepath = $image_dir . '/' . $filename;
    // Returns the path where the file is stored
    return $filepath;
    }
  }

  // Processes images by getting paths and 
  // creating smaller versions of the image
  function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';
  
    // Set up the image path
    $image_path = $dir . $filename;
  
    // Set up the thumbnail image path
    $image_path_tn = $dir.makeThumbnailName($filename);
  
    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);
  
    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
  }

  // Checks and Resizes image
  function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {

    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];
  
    // Set up the function names
    switch ($image_type) {
    case IMAGETYPE_JPEG:
     $image_from_file = 'imagecreatefromjpeg';
     $image_to_file = 'imagejpeg';
    break;
    case IMAGETYPE_GIF:
     $image_from_file = 'imagecreatefromgif';
     $image_to_file = 'imagegif';
    break;
    case IMAGETYPE_PNG:
     $image_from_file = 'imagecreatefrompng';
     $image_to_file = 'imagepng';
    break;
    default:
     return;
   } // ends the swith

    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);

    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;

    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {
    
     // Calculate height and width for the new image
     $ratio = max($width_ratio, $height_ratio);
     $new_height = round($old_height / $ratio);
     $new_width = round($old_width / $ratio);
    
     // Create the new image
     $new_image = imagecreatetruecolor($new_width, $new_height);
    
     // Set transparency according to image type
     if ($image_type == IMAGETYPE_GIF) {
      $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagecolortransparent($new_image, $alpha);
     }
   
     if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
      imagealphablending($new_image, false);
      imagesavealpha($new_image, true);
     }
   
     // Copy old image to new image - this resizes the image
     $new_x = 0;
     $new_y = 0;
     $old_x = 0;
     $old_y = 0;
     imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
   
     // Write the new image to a new file
     $image_to_file($new_image, $new_image_path);
     // Free any memory associated with the new image
     imagedestroy($new_image);
     } else {
     // Write the old image to a new file
     $image_to_file($old_image, $new_image_path);
     }
     // Free any memory associated with the old image
     imagedestroy($old_image);
  } // ends resizeImage function

  // Display thumbnails for particular vehicle
  function buildVehicleThumbnails($vehicleThumbnail){
    $thv = "<div class = 'car-thumbnail'>";
    foreach ($vehicleThumbnail as $thumbnail) {
      $thv .= "<img src='$thumbnail[imgPath]' alt='$thumbnail[imgName]'>";
    }
    $thv .= "</div>";

    return $thv;
  }
  
?>