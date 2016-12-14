<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Delete Category</title>
    </head>
    <body>
        <?php
        // Retrieve the URL parameter called id
        //var_dump($_GET);
        
        if ( (isset($_GET['id'])) && (is_numeric($_GET['id']))    ){
            //FOR GET
            //if we get here:  we found the id parameter and 
            //it's value is numeric
            $id = $_GET['id'];
            //echo $id;
        }elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))){
            //FOR POST
            //var_dump($_POST);
            //exit();
            $id = $_POST['id'];//Get the id from post hidden field called id
        }else{
            //invalid parameter - kill the script
            echo "<h3>This page has been access in error!</h3>";
            echo "<a href='4_ManageCategories.php'>Manage Categories</a>";
            //complete proper html closing tags
            echo "</body></html>";
            exit();
        }
        
        //Good to go - we have the id parameter
        //get the configuration file 
        require './includes/config.php';
        
        //connect to the database
        require MYSQL;
        
        //======================== PROCESS POST ==============================
        //check if form was submitted
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //var_dump($_POST);
            //exit();
            
            //check that user wants to delete this record (selected yes radio button)
            if($_POST['sure']=='yes'){
                //DELETE 
                 //Build the delete statement
                $q = "DELETE FROM categories 
                      WHERE id =$id LIMIT 1";
                //echo $q;
                //exit();
                
                //run the DELETE 
                $r = mysqli_query($dbc,$q);
                
                if(mysqli_affected_rows($dbc)===1){
                    //DELETE ok - show message
                    echo "<p>The Category has been deleted!</p>";

                }else{
                    //error occured - show message
                     echo "<p>The Category was not deleted due to a system error!</p>";
                     echo "<p>" . mysqli_error($dbc). "</p>";
                } 
            }else{
                //DON'T DELETE (user selected no radio button)
                echo "<p>The category has not been deleted!</p>";
                
            } 
           
        }
         //====================== END  PROCESS POST ==========================
        // ALWAYS SHOW THE FORM
   
        
        //Retrieve the specified category for the id param passed in
        $q = "SELECT category FROM categories WHERE id=$id";
        $result = mysqli_query($dbc,$q);
        
        //Test if we have any rows
        if(mysqli_num_rows($result)==1){
            //found our category
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            
            //Create the html form 
    ?>
        
        <h3>Delete Category: <?php echo $row['category']?></h3>
        <form method="post" action="4_DeleteCategory.php">
            <input type="radio" name="sure" value="yes">Yes
            <input type="radio" name="sure" value="no" checked>No
            
            <input type="hidden" name="id" id="id"
                   value="<?php echo $id ?>">
            <br>
            <button type="submit">Delete Category</button>
            
        </form>
        
        
    <?php
        }else{
            //not a valid category
            echo "<p>$id is not a valid category!</p>";
        }
        
        
        
        ?>
        
        <a href="4_ManageCategories.php">Manage Categories</a>
    </body>
</html>