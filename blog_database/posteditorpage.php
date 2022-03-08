<?php
    //Include the connection and session
    include ("connection.php");
    include ("session.php");

    //Check if connection is working
    // if(!$connection){
    //     echo "<h3>Not working!</h3>";
    // } else {
    //     echo "<h3>Working!</h3>";
    // }

    //Add the user who is logged
    $userLoggedIn = $_SESSION['login_user'];
    
    //Create variable to store message if upload was successful or not
    $msg = false;

    // Create a new post
    //Check if the user sent a post using "if" with variable $_POST
    if(isset($_POST["new_post"])){
        $title = $_POST["title"]; 
        $posts = $_POST ["post"];

        //Check if the user uploaded a file using "if" with variable $_FILES that php uses to store files and the name of the field that will upload the file in this case "imageUpload"
        if(isset($_FILES["imagefile"])){

         //Create function to get pathinfo() file extension that receives as parameter the image name and the PATHINFO_EXTENSION.
         $imagefile = $_FILES['imagefile'];
         $extension = strtolower(pathinfo($imagefile['name'], PATHINFO_EXTENSION));
         //Define name/generate unique filenames using uniqid() function which will always generate a different name. I created a variable with the encryption of the filename concatenating with its extension.
         $new_name = md5(uniqid($imagefile['name'])).".".$extension;
         //Set directory where we send the file.
         $directory = "images/";

         //To upload use move_uploaded_file function to access file and tmp_name attribute. The php will go to the location where the file was uploaded and copy it to ($image_directory) with ($new_name)
         move_uploaded_file($_FILES["imagefile"]["tmp_name"], $directory  . $new_name);
        }
        //Execute the query using 'INSERT' command to insert the data to the database. The author will be selected from the user logged in, and the data will be established using the NOW() function that returns the current date and time.
        $sql_code = "INSERT  INTO blogpost(title, post, author, datepost, imagefile) VALUES( '$title', '$posts', '{$_SESSION['login_user']}', NOW(),'$new_name')";
          
          //Run code and send message if post is sent successfully or if it failed
          if(mysqli_query($connection, $sql_code))

          $msg =  "File uploaded successfully!";
          else 
          $msg =  "Failed to upload file!";
    }  

    //Selects everything from the table using id to displayed posts in chronological order starting with the latest 
    $sql = ("SELECT * FROM `blogpost` ORDER BY `blogpost`.`id`DESC");
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
    <!--Create a div for the post form-->
    <div id="postbox">
      <!--Create a div to echo the user-->
     <div id='userwelcome'>
         <?php  echo "Welcome " . $userLoggedIn ?>
     </div>
     <!--Create h2 for post-->
     
     <h2 id="posttitle">Create your post</h2>
     <div id="postfields1">
         <!--Create a form to upload the data. Use "action" on the same php page to send the data to its own page. Method = POST and special "enctype" attribute to notify the system that a file is being uploaded, otherwise the upload doesn't work --> 
         <form action="posteditorpage.php" method="POST" enctype="multipart/form-data">
            <!--Create field for title, post and file/image. For title and post use 'type = text' and for file/image use 'type = file'. Use 'accept' on the file/image input to only enable selecting files of the correct file type.-->
            <label class="postlabel">Add Title</label>
            <input type="text" name="title" id="titleinput" placeholder="Insert Post Title"/><br>
            <label class="postlabel">Add Post</label><input type="text" name="post" id="descriptioninput" placeholder="Insert Post"/><br>
            <div id="imageform">
              <label class="postlabel">Add Image</label><input type="file" name="imagefile" id="imageUpload" value="Choose File" placeholder="Insert image" accept = ".jpg, .jpeg, .png, .gif,">
            </div>
           <!--Create the submit button-->
           <input type="submit" name="new_post" id="postbutton" value="POST">
         </form>
       

       <!--Create a div to add the logout button-->
       <div id="logoutdiv">
          <form action="logout.php" method="post">
            <input type="submit" id="logoutbutton" value="LOGOUT" />
          </form>
       </div>
           <!--Create a div to add the $msg echo and a link to landing page-->
        <div id="linkblogpage">
              <a href= "index.php">Home</a><br>
           </div>
           <div id="uploadmessage">
         <?php if($msg != false) echo "<p>$msg</p>"; ?>
        </div>
        </div>
    </div>
      <!--Create a div to add the posts with an edit and delete button for each one-->
       <div clas="postDiv">
           <?php 
             //Creates the conditions to appear only valid rows taken from the database table. If the number of results is greater than zero, show the data
             if($query->num_rows > 0) {
             //Returns an associative array of strings representing the fetched row.  Echo each row for each data needed to create the post
             while($row = $query->fetch_assoc()) {
           ?> 
            <div class="eachPost">
              <h2><?php echo $row['title'];?></h2></a>
              <!-- To convert the date-time format use strtotime() and date() function. -->
              <h3>Date: <?php echo date("d/m/Y", strtotime($row['datepost']));?></h3>
              <h3>Author: <?php echo $row['author'];?></h3>
              <?php
                 echo "<img src= 'images/". $row['imagefile']."'>";
              ?>
              <p><?php echo $row['post'];?></p>
              <!--Create two forms and two buttons one with "delete" to delete the file and another one with "edit" to edit file. Echo the id row to select post by id -->
              <div>
               <form action="editpost.php?id=<?php echo $row['id']?>" method="post">
                 <input type="submit" id="editbutton" value="EDIT POST" />
               </form>
               <form action="deletepost.php?id=<?php echo $row['id']?>" method="post">
                 <input type="submit" id="buttondelete" value="DELETE" />
               </form>
              </div>
              
            </div>
            <?php
              }}
            
            ?> 
          
        </div>
        
  </body>
</html>
