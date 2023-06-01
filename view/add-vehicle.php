<?php 
// This block of code will determine if the visitor is NOT logged in or
    // if the visitor does NOT have a level access 3. If the visistor is NOT logged in
    // or if the visitor does NOT have a level access 3 the header function will send 
    // them to the main PHP Motors controller.
    if (!$_SESSION['loggedin'] || $_SESSION['clientData']['clientLevel'] !=3) {
        header('Location: ../index.php/');
        exit;
    }


$classificationList = '<select name="classificationId">';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'";
    if(isset($classificationId)) {
        if($classification['classificationId'] == $classificationId){
            $classificationList .= ' selected ';
        }
    }
    
    $classificationList .= "> $classification[classificationName] </option>";
}
$classificationList .= '</select>';

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
    <title>PHP Motors</title>
</head>
<body>
    <div id="wrapper">
    <header>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php'; ?>
    </header>
    <nav id="page_nav">
    <?php //require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/nav.php'; 
            echo $navList; ?>
    </nav>
    <main>
        <h1 id="content-title"> Add Vehicle</h1>
        <?php 
        /**
         * The isset() function tests the variable that is included as a parameter and "Returns TRUE if 
         * the variable exists and has a value other than NULL. Returns FALSE otherwise."
         */
        if (isset($message)) {
            echo $message;
        }
        ?>
        <!-- The method attribute tells the HTTP protocol "How" to send the data. We have two options: post or get. 
                An easy way to remember these is Post means "write", Get means "read". Since we want the registration 
                data to be "written" to the database, we will use post.
             The action attribute tells the HTTP protocol "Where" to send the data. In this instance we want to send 
                it to the accounts controller.
        -->
        <form action="/phpmotors/vehicles/index.php" method="post">
            <p>*Note all fields are required</p>
            <?php 
                echo $classificationList;
            ?>
            <br>
            <label for="invMake"><b>Make: </b></label>
            <input type="text" id="invMake" placeholder="Enter vehicle make" name="invMake" <?php if(isset($invMake)){echo "value='$invMake'";}  ?> required pattern="(?=^.{1,30}$)(?=.*[a-zA-Z]).*$">
            <br>
            <label for="invModel"><b>Model: </b></label>
            <input type="text" id="invModel" placeholder="Enter vehicle model" name="invModel" <?php if(isset($invModel)){echo "value='$invModel'";}  ?> required pattern="(?=^.{1,30}$)(?=.*[a-zA-Z]).*$">
            <br>
            <label for="invDescription"><b>Description: </b></label>
            <input type="text" id="invDescription" placeholder="Enter vehicle description" name="invDescription" <?php if(isset($invDescription)){echo "value='$invDescription'";}  ?> required pattern="(?=^.{1,200}$)(?=.*[a-zA-Z]).*$">
            <br>
            <label for="invImage"><b>Image: </b></label>
            <input type="text" id="invImage" placeholder="Enter image path" name="invImage" <?php if(isset($invImage)){echo "value='$invImage'";}  ?> required>
            <br>
            <label for="invThumbnail"><b>Thumbnail: </b></label>
            <input type="text" id="invThumbnail" placeholder="Enter thumbnail path" name="invThumbnail" <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}  ?> required>
            <br>
            <label for="invPrice"><b>Price: </b></label>
            <input type="text" id="invPrice" placeholder="Enter vehicle price" name="invPrice" <?php if(isset($invPrice)){echo "value='$invPrice'";}  ?> required>
            <br>
            <label for="invStock"><b>Stock #: </b></label>
            <input type="text" id="invStock" placeholder="Enter stock number" name="invStock" <?php if(isset($invStock)){echo "value='$invStock'";}  ?> required pattern="(?=^.{0,6}$)(?=.*[0-9]).*$">
            <br>
            <label for="invColor"><b>Color: </b></label>
            <input type="text" id="invColor" placeholder="Enter vehicle color" name="invColor" <?php if(isset($invColor)){echo "value='$invColor'";}  ?> required pattern="(?=^.{1,30}$)(?=.*[a-zA-Z]).*$">
            <br>
            <input type="submit" name="submit" id="addVBtn" value="add-vehicle">
            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="add-vehicle-info">
        </form>
    </main>
    <hr>
    <footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
    </footer>
    </div>
</body>
</html>