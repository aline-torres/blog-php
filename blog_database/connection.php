<?php

    // These are the database User credentials that were set up to gain acces to the database
    $servername = 'localhost';
    $username = 'blog_database';
    $password = 'blog123';
    $databaseName = 'blog_database';

    //Create a connection using the credentials
    $connection = new mysqli($servername, $username, $password, $databaseName);
    //Check if the connection worked
    if($connection->connect_error) {
        // If the connection had an error, it will be described here, and the Die command will stop the script - it is not possible to go any further
        die("Connection Failed!" . $connection->connect_error);
    }
    
    //If connection worked you should see the next section
    //echo "Connected Successfully <br><br>"

?>