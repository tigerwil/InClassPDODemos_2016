<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Table of Categories</title>
    </head>
    <body>
        <?php
        //get the configuration file 
        require './includes/config.php';
        
        //connect to the database
        require MYSQL;
        
        //1.  Get total number of records in category table
        $sql = 'SELECT COUNT(*) FROM categories';
        $stmt = $dbc->query($sql);
        $cnt = $stmt->fetchColumn();
        
        //2.  Display the number of records (record count)
        echo "<h2>Total Categories: $cnt</h2>";
        
        if($cnt>0){
            //3.  Build the SQL query
            $q = "SELECT id, category FROM categories ORDER BY id";
        
            //4.  Execute the query
            $stmt = $dbc->query($q);
            $category_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            //5.  Display the records in table
            //start the table
            echo "<table border='1'>
                     <tr>
                        <th>ID</th>
                        <th>CATEGORY</th>
                     </tr>";
            
            //6.  Loop all records within $category_list
            foreach($category_list as $row){
                echo "<tr>
                          <td>{$row['id']}</td>
                          <td>{$row['category']}</td>
                      </tr>";
            }
            
            //end the table
            echo "</table>";
        }else{
            //No records ($cnt is not >0)
            echo "<p style='color:red;font-weight:bold'>No rows returned</p>";
        }     
        
        ?>
    </body>
</html>
