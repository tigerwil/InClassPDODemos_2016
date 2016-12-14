<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Category</title>
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
            
            //$cat = trim($_POST['category']);
            //$cat2= filter_var($cat,FILTER_SANITIZE_STRING);
            //$catetory = mysqli_real_escape_string($dbc,$cat2);
           
            $category = trim(filter_var( mysqli_real_escape_string($dbc,$_POST['category']),
                         FILTER_SANITIZE_STRING));
            
            
            //Build the update statement
            $q = "UPDATE categories SET category = '$category'
                  WHERE id =$id LIMIT 1";
            
            //echo $q;
            //exit();
            
            //run the update 
            $r = mysqli_query($dbc,$q);
            
            //Check if it ran ok:  using the mysqli_affected_rows function
            /* This function will return
             * 
             * - An integer greater than ZERO indicating the number of rows
             *   affected
             * 
             * - A ZERO (0) indicating that no records were updated for an 
             *   UPDATE statement
             * 
             * - A MINUS ONE (-1) indicating that the query returned an error
             * 
             * In this example we will be looking for 1 row affected
             * we will use the triple-equals to eliminate any confusion
             * with a true|false returns
             * 
             */
            
            if(mysqli_affected_rows($dbc)===1){
                //update ok - show message
                echo "<p>The Category has been updated!</p>";
            }elseif (mysqli_affected_rows($dbc)===0){
                //no row updated (value was unchanged) - show message
                 echo "<p>The Category has not been updated
                          because it was the same as on record!</p>";

            }else{
                //error occured - show message
                 echo "<p>The Category was not updated due to a system error!</p>";
                 echo "<p>" . mysqli_error($dbc). "</p>";
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
        <form method="post" action="4_EditCategory.php">
            Category Name:
            <input type="text" name="category" id="category"
                   autofocus value="<?php echo $row['category'] ?>">
            <input type="hidden" name="id" id="id"
                   value="<?php echo $id ?>">
            <br>
            <button type="submit">Edit Category</button>
            
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
