<div id="top-header">
    <a href="/phpmotors/home.php" title="Go to the PHP Motors home page">
        <img src="/phpmotors/images/site/logo.png" alt="PHP Motors Logo" id="logo">
    </a>
    <?php 
        //if(isset($_SESSION['loggedin'])){
            //echo '<a href="/phpmotors/accounts" title="welcome" id="welcome">Welcome '. ' '.$_SESSION['clientData']['clientFirstname'].'</a>';
        //}   
    ?>
    <div id="account">
        <!--    The question mark is called a query string.
                This means it is a query to pass parameters in a key-value format.
                I believe this will help the link pass the parameter by the action,
                then accounts controller will recognize the value down in the
                switch case statement.
                Requests are handled either by reading a file from its file system based on the URL 
                path or by handling the request using logic that is specific to the type 
                of resource. In cases where special logic is invoked, the query string 
                will be available to that logic for use in its processing, along with 
                the path component of the URL.
            -->
        <?php 
            /**
             * To enable this logout process to happen, code will have to be added to the views to accomplish the following:
             * If a site visitor (the client) is not logged in, the "My Account" link should be present and operational (as it currently exists).
             * When the client is "logged in" the "My Account" link should be replaced with a "Log out" link that points to the 
             * accounts controller and passes the appropriate name value pair to trigger the logout event.
             * This code area can also be where the welcome message and link are displayed or hidden.
             */
            if(isset($_SESSION['loggedin'])){
                echo '<a href="/phpmotors/accounts" title="welcome" id="welcome">Welcome '. ' '.$_SESSION['clientData']['clientFirstname'].'</a>';
                echo '<a href="/phpmotors/accounts?action=logout" title="log out" id="acc">Log Out</a>';
            } else {
                echo '<a href="/phpmotors/accounts?action=login" title="Login or Sign up" id="acc">My Account</a>';
            } 
        
        ?> 
        <!-- <a href="/phpmotors/accounts?action=login" title="Login or Sign up" id="acc">My Account</a> -->
    </div>
</div>