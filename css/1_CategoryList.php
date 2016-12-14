<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>List of Categories</title>
    </head>
    <body>
        <?php
        /*
         * 2 ways to bring externale scripts into existing:
         *   1- Include
         *   2- Require
         * 
         * Note:  also include_once and require_once
         * 
         * Differences b/w each are:
         * 
         * Failure to include a file results in a warning and the script 
         * continues ...
         * 
         * Failure to require a file results a fatal error and the script
         * is halted
         * 
         * Typically include files like html header, footer, sidebar etc
         * 
         * Typically require files that are critical to the site's functionality
         * like database connections, configuration files, etc.
         * 
         */
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
            //start the list
            echo "<ul>";
            
            //Loop all records within the variable $r 
            //this is an array of mysql records:  recordset|resultset
            while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
                //MYSQLI_ASSOC:  use the column names from the resultset
                //$row['id']
                //$row['category']
                
                //MYSQLI_NUM:  We could also use the index number 
                //$row[0]
                //$row[1]
                
                //MYSQLI_BOTH: We could use column name and index number
                //$row['id']
                //$row[1]
                
                echo "<li>"  .$row['id'] . " - " . $row['category'] ."</li>";
                // 1 - General Web Security
                // 2 - PHP Security
            }           
            
            
            //end the list
            echo "</ul>";
        }
        
        
        ?>
    </body>
</html>
