<!DOCTYPE html>
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
        <form action="/phpmotors/accounts/index.php" method="post">
            <header>Register</header>
            <p>Please fill in this form to create an account.</p>

            <label for="fname"><b>First Name: </b></label>
            <input type="text" id="fname" placeholder="Enter First Name" name="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?> required>
            <label for="lname"><b>Last Name: </b></label>
            <input type="text" id="lname" placeholder="Enter Last Name" name="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?> required>
            <label for="email">Email: </label>
            <input type="email" id="email" placeholder="Enter Email" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?> required>
            <label for="psw"><b>Password: </b></label>
            <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span>
            <!--The password field will require the password is at least 8 characters, has at least 1 uppercase character, 1 number and 1 special character.-->
            <input type="password" id="psw" placeholder="Enter Password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
            <input type="submit" name="submit" id="regbtn" value="Register">
            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="register">
        </form>
    </main>
    <hr>
    <footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
    </footer>
    </div>
</body>
</html>