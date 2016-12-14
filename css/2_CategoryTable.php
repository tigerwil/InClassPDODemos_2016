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
        
        //1.  Build the SQL query
        $q = "SELECT id, category FROM categories ORDER BY id";
        
        //2.  Execute the query
        $r = mysqli_query($dbc, $q);
        
        //3.  Check the number of records in recordset
        $cnt = mysqli_num_rows($r);
        
        //4.  Display the number of records (record count)
        echo "<h2>Total Categories: $cnt</h2>";        
        
        //5.  Display the records in unordered list, if we have records
        if($cnt>0){
            //start the table
            echo "<table border='1'>
                     <tr>
                        <th>ID</th>
                        <th>CATEGORY</th>
                     </tr>";
            
            //Loop all records within the variable $r 
            //this is an array of mysql records:  recordset|resultset
            while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
                
                //echo "<tr><td>"  .$row['id'] . "</td><td>" . $row['category'] ."</td></tr>";
                echo "<tr>
                          <td>{$row['id']}</td>
                          <td>{$row['category']}</td>
                      </tr>";
                // 
                // // 1 - General Web Security
                // 2 - PHP Security
            }           
            
            
            //end the list
            echo "</table>";
        }
        
        
        ?>
    </body>
</html>
