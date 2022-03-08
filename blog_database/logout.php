<?php
//Include a start session
session_start();

//Unset the session using the user login variable
unset($_SESSION['login_user']);
?>


<script> 
//Redirect user to login.php
var loginpage = location.href = 'login.php';
</script>

