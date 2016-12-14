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
           
            $category = trim(filter_var($_POST['category'],FILTER_SANITIZE_STRING));
            
            //test if user entered something in input
            if(!empty($category)){
                //Build the update statement 
                $stmt = $dbc->prepare("UPDATE categories SET category =:category
                                       WHERE id =:id LIMIT 1");
                //Using PDO Prepared statment with named parameters
                // :category
                // :id
                
                //Bind those 2 paremeters to values 
                $stmt->bindValue(':category', $category, PDO::PARAM_STR);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                
                //Execute the statement
                try{
                    $stmt->execute();
                    echo "<p>The Category has been updated!</p>";                    
                } catch (Exception $ex) {
                    //error occured - show message
                    echo "<p>The Category was not updated due to a system error!</p>";
                    echo "<p>" . $ex->getMessage(). "</p>";
                }//end of try...catch
                
            }  //End if not empty   
          
        } //====================== END  PROCESS POST ==========================
        

        // ALWAYS SHOW THE FORM
   
        
        //Retrieve the specified category for the id param passed in
        $q = "SELECT category FROM categories WHERE id=$id";
        $stmt = $dbc->query($q);
        $row = $stmt->fetchColumn();
        
        
        
        //Test if we have any rows
        if($row){
            //found our category
            
            //Create the html form 
    ?>
        <form method="post" action="4_EditCategory.php">
            Category Name:
            <input type="text" name="category" id="category"
                   autofocus value="<?php echo $row ?>">
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
