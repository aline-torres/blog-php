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
  
   // Create request method to be used to access the page. The request method to be used to access the page will be POST.
   if($_SERVER["REQUEST_METHOD"] == "POST") { 

    //Use the mysqli_real_escape_string() function which escapes special characters in a string for use in an SQL query, taking into account the connection's current character set.
      $emailPosted = $_POST['email'];
      $email= mysqli_real_escape_string($connection,$emailPosted);

      $passwordPosted = $_POST['password'];
      $password = mysqli_real_escape_string($connection,$passwordPosted);

      $namePosted = $_POST['name'];
      $name = mysqli_real_escape_string($connection,$namePosted);

      //Create a query to check if the user exists in the user table and the user data needed to login
      $sql = "SELECT id_user FROM blog_user WHERE name='$name' AND email='$email' AND password='$password'";
      
      //Create the connection between php and sql
      $query = mysqli_query($connection, $sql);
      
      // Use 'mysqli_fetch_array' to fetch a row of data from the result set and return the result row as an associative array, a numeric array, or both. When using the constant MYSQLI_ASSOC, this function will behave identically to mysqli_fetch_assoc().
      $row = mysqli_fetch_array($query, MYSQLI_ASSOC);

      // Create variable to store the total number of rows in a result set
      $count = mysqli_num_rows($query);

      //Create a session. The session is an information type that is stored in php and permeates all pages. no matter which page is on the site, the variable will exist
      //If there is at least one registered user, check the following parameters. If check success go to posteditorpage.php. If the check is unsuccessful, display an error message.
      if($count == 1) {
          $_SESSION['login_user'] = $name;
          $_SESSION['login_user_email'] = $row['email'];
          $_SESSION['login_user_id'] = $row['id_user'];
          header("location: posteditorpage.php");
     } else {
          $feedback = "Your username and/or password are incorrect!";
        }
    } else {
         $feedback = "Please insert your username and password...";
    }

    //Connect to the css file
    echo "<link rel='stylesheet' href='style.css'>";
?>

<html>
 <body>

  <header id="header">
    <h1>Movies Blog</h1>
  </header>

  <div id="loginbox">
    <h2 id="logintitle">Login to Movie Blog </h2>

     <div id="loginfields">
     <!--Create a form to upload the data using 'Method = POST' -->
     <form action = "" method = "POST">
         <!-- Create field for user name, email and password and use 'type = text' -->
      <div>
         <label class="loginlabel1">Name</label><input type = "text" name = "name" placeholder="User Name" class="logininput"><br><br>
         <label class="loginlabel2">Email</label><input type = "text" name = "email" placeholder="User Email" class="logininput"><br><br>
         <label class="loginlabel3">Password</label><input type = "text" name = "password" placeholder="Password" class="logininput"><br><br>
      </div>
         <!--Create the submit button-->
         <input type = "submit" id="loginbutton" value = "LOGIN"><br>
         <!--Create a div to add the $feedback echo-->
         <div id="feedback">
           <?php echo $feedback; ?>
        </div>
     </form>
    </div>
    <div id="linkblogpage">    
          <a href= "index.php">Blog Page</a><br>  
             
      </div>
 </div>
 <body>
</html>