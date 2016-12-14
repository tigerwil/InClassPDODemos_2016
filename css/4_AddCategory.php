<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Category</title>
    </head>
    <body>
        <?php
        // handle post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //see what is in the POST array
            //var_dump($_POST);

            if (!empty($_POST['category'])) {//if user entered value for category input
                //good
                //get db conn
                require './includes/config.php';
                require MYSQL;
                $category = trim(filter_var(mysqli_real_escape_string($dbc, $_POST['category']), FILTER_SANITIZE_STRING));
            
                //1.  Check for duplicate category name
                $q = "SELECT COUNT(*) FROM categories WHERE category = '$category'";
                $result = mysqli_query($dbc,$q);
                $row = mysqli_fetch_array($result, MYSQLI_NUM);
                
                //get count
                $cnt = $row[0];
                
                if ($cnt>=1){
                    //duplicate entry
                    $error = "That category already exists!";
                }else{
                     //2. Add new category name (if not a duplicate)
                    //Build our INSERT stmt using prepared statements
                    
                    $q = "INSERT INTO categories (category) VALUES(?)";
                    //1. prepare the statement
                    $stmt = mysqli_prepare($dbc, $q);
                    //2. bind the parameter
                    mysqli_stmt_bind_param($stmt,'s', $category);
                    //"INSERT INTO categories (category) VALUES('Visual Studio')";
                  
                    //3. execute the prepared statement
                    mysqli_stmt_execute($stmt);
                    //4. get the rows affected by prepared statement
                    $count = mysqli_stmt_affected_rows($stmt);
                    //5. close the statement
                    mysqli_stmt_close($stmt);
                    
                    //Check if successful
                    if($count>0){
                        //success
                        echo "<p>The category was successfully added!</p>";
                    }else{
                        //fail
                        echo "<p>Error adding category!</p>";
                    }                   
                }          
            } else {
                //no value entered by user - show message
                echo "<p>Category name is required!</p>";
            }
        }//END OF FORM SUBMISSION
        
        //Display error if needed
        if(isset($error)){
            echo "<h2>Error!</h2>   
                  <p style='color:red;font-weight:bold'>$error<br>
                   Please try again!</p>";
        }
        
        ?>
        <h3>Add a new Category</h3>
        <form action="4_AddCategory.php" method="post">
            <input type="text" name="category" id="category"
                   placeholder="Enter category name"
                   autofocus required
                   value="<?php if (isset($_POST['category'] ))echo $_POST['category']; ?>">
            <button type="submit">Add Category</button>

        </form>
        <br>
         <a href="4_ManageCategories.php">Manage Categories</a>
    </body>
</html>