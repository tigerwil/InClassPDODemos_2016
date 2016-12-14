<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Manage Categories</title>
        <link href="css/site.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php

        //get the configuration file 
        require './includes/config.php';
        
        //connect to the database
        require MYSQL;
        
        //1.  Build the SQL query
        $q = "SELECT COUNT(*) FROM categories";
        $stmt = $dbc->query($q);
        $cnt = $stmt->fetchColumn();
        
        //var_dump($cnt);
        //exit();
        
        //  Display the number of records (record count)
        echo "<h2>Total Categories: $cnt</h2>";  
        
        if($cnt>0){
            //we have some records - display it html table
            //build new query 
            $q = "SELECT id, category FROM categories ORDER BY id";
            
            //execute the query
             $stmt = $dbc->query($q);
             $category_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
             //var_dump($category_list);
             //exit();
             
             //build html table and print 
              //start the table
            echo "<table>
                     <tr>
                        <th>Id</th>
                        <th>Category</th>
                        <th>Manage</th>
                     </tr>";
            
            //loop the array
            foreach($category_list as $row){
                echo "<tr>
                          <td>{$row['id']}</td>
                          <td>{$row['category']}</td>
                          <td><a href='4_EditCategory.php?id={$row['id']}'>Edit</a> | <a href='4_DeleteCategory.php?id={$row['id']}'>Delete</a></td>
                      </tr>";                
            }
            
            //end the table
            echo "</table>";
             
        }//end if cnt>0       
        
        ?>
        <hr>
        <a href="4_AddCategory.php">Add Category</a>
    </body>
</html>
