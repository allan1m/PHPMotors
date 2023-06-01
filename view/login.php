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
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
       }
    ?>
    <form action="/phpmotors/accounts/index.php" method="post">
        <div class="container">
            <label for="email"><b>Email</b></label>
            <br>
            <input type="email" id="email" placeholder="Enter Email" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?> required>
            <br>           
            <label for="psw"><b>Password</b></label>
            <br>
            <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span>
            <br>
            <!--The password field will require the password is at least 8 characters, has at least 1 uppercase character, 1 number and 1 special character.-->
            <input type="password" id="psw" placeholder="Enter Password" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
            <br>
            <button type="submit" id="login-submit" value="Send Post">Login</button>
            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="login">
        </div>
    </form>
        <a href="/phpmotors/accounts?action=signup" title="Sign up" id="signup">Register</a>
    </main>
    <hr>
    <footer>
    <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
    </footer>
    </div>
</body>
</html>