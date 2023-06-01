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
        <h1 id="content-title"> Add Car Classification</h1>
        <?php 
        /**
         * The isset() function tests the variable that is included as a parameter and "Returns TRUE if 
         * the variable exists and has a value other than NULL. Returns FALSE otherwise."
         */
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form action="/phpmotors/vehicles/index.php" method="post">
            <header> Add Car Classification</header>

            <label for="classificationName"><b>Classification Name</b></label>
            <br>
            <span>Classification may not exceed 30 characters.</span>
            <br>
            <input type="text" name="classificationName" id="classificationName" <?php if(isset($classificationName)){echo "value='$classificationName'";}  ?> required pattern="(?=^.{1,30}$)(?=.*[a-zA-Z]).*$">
            <br>
            <input type="submit" name="submit" id="classbtn" value="Add Classification">
            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="add-car-classification">
        </form>
    </main>
    <hr>
    <footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
    </footer>
    </div>
</body>
</html>