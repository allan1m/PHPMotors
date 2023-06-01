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
    <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
    ?>
    <p>You are logged in</p>
    <h1><?php echo $_SESSION['clientData']['clientFirstname'].' '.$_SESSION['clientData']['clientLastname']; ?></h1>
    <ul>
        <li><?php echo 'ID: '.$_SESSION['clientData']['clientId']; ?></li>
        <li><?php echo 'First Name: '.$_SESSION['clientData']['clientFirstname']; ?></li>
        <li><?php echo 'Last Name: '.$_SESSION['clientData']['clientLastname']; ?></li>
        <li><?php echo 'First Name: '.$_SESSION['clientData']['clientEmail']; ?></li>
    </ul>

    <h2>Manage Account</h2>
    <a href="../accounts/index.php?action=update">update account information</a>

    <?php 
        if ($_SESSION['clientData']['clientLevel'] > 1) {
            echo "<h2>Manage Inventory</h2>";
            echo "<a href='/phpmotors/vehicles'>update vehicle info</a>";
        }
    ?>
    </main>
    <hr>
    <footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
    </footer>
    </div>
</body>
</html>