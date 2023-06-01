<?php 
// This block of code will determine if the visitor is NOT logged in or
    // if the visitor does NOT have a level access 3. If the visistor is NOT logged in
    // or if the visitor does NOT have a level access 3 the header function will send 
    // them to the main PHP Motors controller.
    if (!$_SESSION['loggedin'] || $_SESSION['clientData']['clientLevel'] !=3) {
        header('Location: ../index.php/');
        exit;
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
    <title><?php if(isset($invInfo['invMake'])){ echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?> | PHP Motors</title>
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
        <h1 id="content-title"> <?php if(isset($invInfo['invMake'])){ echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?></h1>
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
            <p>*Confirm vehicle deletion. The delete is permanent.</p>
            <br>
            <label for="invMake"><b>Make: </b></label>
            <input type="text" id="invMake" readonly name="invMake" <?php if(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?> >
            <br>
            <label for="invModel"><b>Model: </b></label>
            <input type="text" id="invModel" readonly name="invModel" <?php if(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?> >
            <br>
            <label for="invDescription"><b>Description: </b></label>
            <input type="text" id="invDescription" readonly name="invDescription" <?php if(isset($invInfo['invDescription'])) {echo "value='$invInfo[invDescription]'"; }?> >
            <br>
            <input type="submit" name="submit" id="updateVehicle" value="Delete Vehicle">
            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="deleteVehicle">
            <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){echo $invInfo['invId'];} ?>">
        </form>
    </main>
    <hr>
    <footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
    </footer>
    </div>
</body>
</html>