<?php
    
    //Include the connection 
    include("connection.php");
   
    // //Check if connection is working
    // if(!$connection){
    //     echo "<h3>Not working!</h3>";
    // } else {
    //     echo "<h3>Working!</h3>";
    // }

    //Selects everything from the table using id to displayed posts in chronological order starting with the latest and limit of 10 entries
    $query = ("SELECT * FROM `blogpost` ORDER BY `blogpost`.`id` DESC LIMIT 10");
    //Create the connection between php and sql
    $result = $connection->query($query);
    
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
             
	          //Creates the conditions to appear only valid rows taken from the database table. If the number of results is greater than zero, show the data
             if($result->num_rows > 0) {
             //Returns an associative array of strings representing the fetched row. Echo each row for each data needed to create the post
             while($row = $result->fetch_assoc()) {
           ?> 
            <div class="eachPost">
              <!-- Create a link using the post title to go to a dedicated page for each entry. Echo the id row to select post by id -->
              <a href="postpage.php?id=<?php echo $row['id']?>"><h2><?php echo $row['title'];?></h2></a>
              <!-- To convert the date-time format use strtotime() and date() function. -->
              <h3>Date: <?php echo date("d/m/Y", strtotime($row['datepost']));?></h3>
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
        <div id="loginindexbuttondiv">
            <!--Create a form to go to login page using a button-->
          <form action="login.php">
              <button type="submit" id="loginindexbutton" style="width: 400px; height: 50px; font-weight: bold ">Login Page</button>
          </form>
        </div>

    </body>
</html>


