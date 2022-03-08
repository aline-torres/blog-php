<?php
    
    //Include the connection 
    include("connection.php");
    
    // //Check if connection is working
    // if(!$connection){
    //     echo "<h3>Not working!</h3>";
    // } else {
    //     echo "<h3>Working!</h3>";
    // }

    //Create variable to request the 'id'
    $id = $_REQUEST['id'];

    //Selects everything from the table and get post data based on id
    $sql = ("SELECT * FROM `blogpost` WHERE id = $id");

    //Create the connection between php and sql
    $query = mysqli_query($connection, $sql);

    //Connect to the css file
    echo "<link rel='stylesheet' href='style.css'>";
    
?>

<html>
    <body>
    <!--Create a header-->
    <header id="header">
    <h1>Movies Blog</h1>
    </header>

        <div clas="postDiv">
        <?php 
            // Get post data based on id
             if(isset($_REQUEST['id'])){
             
             //Returns an associative array of strings representing the fetched row. Echo each row for each data needed to create the post
             while($row = $query->fetch_assoc()) {
           ?> 
           <div class="eachPost">
              <!-- Create a link using the post title to go to a dedicated page for each entry. Echo the id row to select post by id -->
              <a href="postpage.php?id=<?php echo $row['id']?>"><h2><?php echo $row['title'];?></h2></a>
              <!-- To convert the date-time format use strtotime() and date() function. -->
              <h3>Date: <?php echo date("d/m/Y", strtotime ($row['datepost']));?></h3>
              <h3>Author: <?php echo $row['author'];?></h3>
              <?php
                 echo "<img src= 'images/". $row['imagefile']."'>";
              ?>              
              <p><?php echo $row['post'];?></p>
             </div>

            <?php
              }}
            ?> 
        </div>
        <!--Create a div with a link to the index page-->
        <div id="linkindex">
             <a href= "index.php">Back to Home</a><br>
       </div>
       <div id="loginindexbuttondiv">
            <!--Create a form to go to login page using a button-->
          <form action="login.php">
              <button type="submit" id="loginindexbutton" style="width: 400px; height: 50px; font-weight: bold ">Login Page</button>
          </form>
        </div>
    </body>
</html>






