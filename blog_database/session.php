<?php

//Include the connection and start session
include('connection.php');
session_start();

//Check if connection is working
    // if(!$connection){
    //     echo "<h3>Not working!</h3>";
    // } else {
    //     echo "<h3>Working!</h3>";
    // }

//Check if there is already an user logged in the session
$user_check = $_SESSION['login_user'];

//Create a query to check if the user exists in the user table
$sql = "SELECT email FROM blog_user WHERE email = '$user_check'";

 //Create the connection between php and sql
$query = mysqli_query($connection, $sql);

//Create variable row
$row = mysqli_fetch_array($query,MYSQLI_ASSOC);

$login_session = $row['email'];
//Se a sessao funcionar conectar usuario
if(!isset($_SESSION['login_user'])) {
    header("location:login.php");
    die();
}
// } else {
//     echo "ok!";
// }
?>