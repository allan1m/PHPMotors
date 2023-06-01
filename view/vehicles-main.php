<?php 
    // This block of code will determine if the visitor is NOT logged in. If the visistor is NOT logged in
    // the header function will send them to the main PHP Motors controller.
    if (!$_SESSION['loggedin'] || $_SESSION['clientData']['clientLevel'] !=3) {
        header('Location: ../index.php/');
        exit;
    } 

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
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
    <!--This view contains two links:
        1. One to the controller that will trigger the delivery of the add classification view.
        2. One to the controller that will trigger the delivery of the add vehicle view. 
     -->
    <a href="/phpmotors/vehicles?action=add-classification" title="Add Classification" id="addClassification">Add Classification</a>
    <a href="/phpmotors/vehicles?action=add-vehicle" title="Add Vehicle" id="addVehicle">Add Vehicle</a>
    
    <?php
    //An "if" test to see if the message variable exists.
    if (isset($message)) { 
        // If the test is true, the message is displayed.
        echo $message; 
    } 
    // An "if" test to see if the classificationList variable exists.
    if (isset($classificationList)) { 
        // If the test is true it builds a level 2 heading and paragraph for this section of content.
        echo '<h2>Vehicles By Classification</h2>'; 
        echo '<p>Choose a classification to see those vehicles</p>'; 
        // Displays the classification list which has been encoded into an HTML select element.
        echo $classificationList; 
    }
    ?>
    <noscript>
    <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
    </noscript>
    <!-- Typically when an HTML table is built it consists of the <table> element, then inside you may find a <thead>, <tfoot> and 
            <tbody> elements. In our case, we only want the outer <table> element. All of the interior elements and content will be 
            created by JavaScript, then "injected" into the table element — this is known as DOM manipulation.
        Note the id attribute and its value. They will be used as a JavaScript hook to know where to inject the inventory list. 
    -->
    <table id="inventoryDisplay"></table>
    </main>
    <hr>
    <footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
    </footer>
    </div>
    <script src="../js/inventory.js"></script>
</body>
</html><?php unset($_SESSION['message']); ?>