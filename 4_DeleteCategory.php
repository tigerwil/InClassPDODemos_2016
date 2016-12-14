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
                $stmt = $dbc->prepare("DELETE FROM categories 
                                      WHERE id =:id LIMIT 1");
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);

                
                //run the DELETE 
                try{
                    $stmt->execute();
                    echo "<p>The Category has been deleted!</p>";
                } catch (Exception $ex) {
                    //var_dump($ex);
                    $info = $ex->errorInfo[1];
                    //var_dump($info);
                    if($info==1451){
                        //FK Violation (cannot delete a parent when child records
                        echo "<p>Cannot delete this category, there are related records!</p>";
                    }else{
                         echo "<p>The Category was not deleted due to a system error!</p>";
                         echo "<p>". $ex->getMessage() ."</p>";
                    }

                }
                
            }else{
                //DON'T DELETE (user selected no radio button)
                echo "<p>The category has not been deleted!</p>";
                
            } 
           
        }
         //====================== END  PROCESS POST ==========================
        // ALWAYS SHOW THE FORM
        $sql = "SELECT COUNT(*) FROM categories WHERE id=$id";
        $stmt = $dbc->query($sql);
        $cnt = $stmt->fetchColumn();
        
        if($cnt==1){//if we find any records with that id
            //get that row|column
            $q = "SELECT category FROM categories WHERE id=$id";
            $stmt = $dbc->query($q);
            $row = $stmt->fetchColumn();
            
            echo "<h3>Delete Category: $row </h3>";
        
       
            
            //Create the html form 
    ?>
        
        
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
            echo "<p>$id is not a valid category. Did you just delete it!</p>";
        }
        
        
        
        ?>
        
        <a href="4_ManageCategories.php">Manage Categories</a>
    </body>
</html>