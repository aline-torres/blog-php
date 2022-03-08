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

    //Create variable to store message if update was successful or not
    $msg = false;

    //Create variable to request the 'id'
    $id = $_REQUEST['id'];

    //Selects everything from the table and get post data based on id
    $sql = ("SELECT * FROM `blogpost` WHERE id = $id");

    //Create the connection between php and sql
    $querysql = mysqli_query($connection, $sql);


    // Update a post
    if(isset($_POST['update'])){
        $id = $_POST ['id'];
        $title = $_POST['title'];
        $post = $_POST['post'];
        $new_image = $_FILES["imagefilenew"];
        $old_image = $_POST ['imagefile_old']; 
        
           if ($new_image != ''){
               //Create function to get pathinfo() file extension that receives as parameter the image name and the PATHINFO_EXTENSION.
               $update_file =  $_FILES["imagefilenew"];
               $extension = strtolower(pathinfo($update_file['name'], PATHINFO_EXTENSION));
               //Define name/generate unique filenames using uniqid() function which will always generate a different name. I created a variable with the encryption of the filename concatenating with its extension.
               $new_name2 = md5(uniqid($update_file['name'])).".".$extension;
               //Set directory where we send the file.
               $directory = "images/";
   
              //To upload use move_uploaded_file function to access file and tmp_name attribute. The php will go to the location where the file was uploaded and copy it to ($image_directory) with ($new_name)
              move_uploaded_file($_FILES["imagefilenew"]["tmp_name"], $directory  . $new_name2);
           } else {
                //Keep the old image
                $update_file = $old_image;
            
           }
        

        //Execute the query using 'UPDATE' command to insert the new data to the database
        $sql = "UPDATE blogpost SET title = '$title', post = '$post', imagefile = '{$new_name2}' WHERE id = $id";
        //Run code and send message if post was updated successfully or if it failed
        $query = mysqli_query($connection, $sql);
        if($query) {

        $msg =  "File updated successfully!";
    }else {
        $msg =  "Failed to update file!";
    } }

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
         <?php  echo "Welcome to Edit Page " . $userLoggedIn ?>
     </div>
     <!--Create h2 for post-->
     <h2 id="posttitle">Edit your post</h2>
      <div id="postfields1">
      <?php 
            // Get post data based on id
             if(isset($_REQUEST['id'])){
             //Returns an associative array of strings representing the fetched row. 
             while($row = $querysql->fetch_assoc()) {
        ?>
         <!--Create a form to update the data. Use "action" on the same php page to send the data to its own page. Method = POST and special "enctype" attribute to notify the system that a file is being uploaded, otherwise the upload doesn't work --> 
         <form action="" method="POST" enctype="multipart/form-data">
             <input type="text" hidden name="id" value="<?php echo $row['id']?>">
            <!--Create field for title, post and file/image. For title and post use 'type = text' and for file/image use 'type = file'. Use 'accept' on the file/image input to only enable selecting files of the correct file type.-->
            <label class="postlabel">Edit Title</label>
            <input type="text" name="title" id="titleinput"  value= "<?php echo $row['title'];?>"/><br>
            <label class="postlabel">Edit Post</label><input type="text" name="post" id="descriptioninput"  value="<?php echo $row['post'];?>"/><br>
            <!--Create the submit button-->
         
          <div id="imageform">
              <label class="postlabel">Edit Image</label>
              <input type="file" name="imagefilenew" accept = ".jpg, .jpeg, .png, .gif,">
              <input type="text" name="imagefile_old" id="imageUpload"  value="<?php echo $row['imagefile'];?>"  >
            </div>
            <input type="submit" name="update" id="postbutton" value="UPDATE">
         </form>
        
         <?php
              }}
            ?> 
       
        
           <!--Create a div to add the $msg echo and a link to landing page-->
           <div id="linkblogpage">
              <a href= "index.php">BLOG PAGE</a><br>
              <a href= "posteditorpage.php">Create Your Post Page</a><br>
           </div>
       <!--Create a div to add the logout button-->
       <div id="logoutdiv">
          <form action="logout.php" method="post">
            <input type="submit" id="logoutbutton" value="LOGOUT" />
          </form>
          </div>
       </div>
       <div id="uploadmessage">
         <?php if($msg != false) echo "<p>$msg</p>"; ?>
        </div>
    </div>
      
        
  </body>
</html>
