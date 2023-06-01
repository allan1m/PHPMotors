<?php 
    // This block of code will determine if the visitor is NOT logged in. If the visistor is NOT logged in
    // the header function will send them to the main PHP Motors controller.
    if (!$_SESSION['loggedin']) {
        header('Location: ../index.php/');
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
    <h1>Update Account Information</h1>
    <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
    ?>
    <h2>Account Update</h2>
    <form action="/phpmotors/accounts/index.php" method="post">
            <label for="fname"><b>First Name: </b></label>
            <input type="text" id="fname" placeholder="Enter First Name" name="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} elseif(isset($_SESSION['clientData']['clientFirstname'])) {echo "value='".$_SESSION['clientData']['clientFirstname']."'"; } ?> required> <br>
            <label for="lname"><b>Last Name: </b></label>
            <input type="text" id="lname" placeholder="Enter Last Name" name="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} elseif(isset($_SESSION['clientData']['clientLastname'])) {echo "value='".$_SESSION['clientData']['clientLastname']."'"; } ?> required> <br>
            <label for="email">Email: </label>
            <input type="email" id="email" placeholder="Enter Email" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} elseif(isset($_SESSION['clientData']['clientEmail'])) {echo "value='".$_SESSION['clientData']['clientEmail']."'"; } ?> required> <br>
            <input type="submit" name="submit" id="submitB" value="Update Information">
            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="updateInfo">
            <input type="hidden" name="clientId" <?php if (isset($_SESSION['clientData']['clientId'])) {echo "value='".$_SESSION['clientData']['clientId']."'";}?>>
    </form>

    <h2>Password Update</h2>
    <form action="/phpmotors/accounts/index.php" method="post">
        <label for="newpsw"><b>New Password: </b></label><br>
        <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
        <!--The password field will require the password is at least 8 characters, has at least 1 uppercase character, 1 number and 1 special character.-->
        <input type="password" id="newpsw" placeholder="Enter Password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
        <input type="submit" name="submit" id="submitB2" value="Update Password">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="updatePassword">
        <input type="hidden" name="clientId" <?php if (isset($_SESSION['clientData']['clientId'])) {echo "value='".$_SESSION['clientData']['clientId']."'";}?>>
    </form>
    </main>    
    <hr>
    <footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
    </footer>
    </div>
</body>
</html>