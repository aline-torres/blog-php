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

    // Delete a post 
    if(isset($_REQUEST['delete'])){
        $id = $_REQUEST['id'];
        //Selects post from the table based on id to delete
        $sql = "DELETE FROM blogpost WHERE id = $id";
        
        //Run code and send message if post is deleted successfully or if failed
        if(mysqli_query($connection, $sql)){   
?>
<script> alert('Post has been successfully deleted!'); 
window.location.replace("posteditorpage.php");
</script>
<?php
 } else{ 
?>
<script> alert('Failed to delete file!'); 
window.location.replace("deletepost.php");
 </script>

 <?php
  }}
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
             
             //Returns an associative array of strings representing the fetched row.  Echo each row for each data needed to create the post
             while($row = $query->fetch_assoc()) {
           ?> 
           <div class="eachPost">
              <h2><?php echo $row['title'];?></h2></a>
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
               <!--Create two forms and two buttons one with "yes" to delete the file and another one with "no" to keep the post and go back to posteditorpage -->
               <div id="deleteBtns">
                    <h2>Do you like to delete this post?</h2>
                  <form action="" method="post">
                  <input type="submit" id="deletebuttonyes" name= "delete" value="YES"/>
                  </form>

                  <form action="posteditorpage.php" >
                  <input type="submit" id="deletebuttoncancel" value="CANCEL" />
                  </form>
               </div> 
               
              <!--Create a div with a link to the index page and create post page-->
              <div id="linkdeletepage">
                 <a href= "index.php">BLOG PAGE</a><br>
                 <a href= "posteditorpage.php">Create Your Post Page</a><br>
              </div>
            </div>  
        </div>
    </body>
</html>