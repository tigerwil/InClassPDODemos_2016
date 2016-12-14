<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Articles by Category</title>
        <link href="css/site.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        //get the configuration file 
        require './includes/config.php';
        
        //connect to the database
        require MYSQL;
        
        
        ?>
        <form method="post" action="3_ArticlesByCategory.php">
            Select Category:
            <select name="category" id="category"  onchange="this.form.submit();">
                <option value="all">View All</option>
                <?php
                    //get all categories
                    //1.  Build the SQL query
                    $q = "SELECT id, category FROM categories ORDER BY category";

                    //2.  Execute the query
                    //$r = mysqli_query($dbc, $q);  
                    $stmt = $dbc->query($q);
                    $category_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    //var_dump($category_list);
                    //exit();
                    
                    //3.  Loop the recorset - printing an option for each record
                    foreach($category_list as $row){
                     echo "<option value=\"{$row['id']}\"";
                       if(isset($_POST['category']) && ($_POST['category']==$row['id'] ) ) echo ' selected';
                       echo ">{$row['category']}</option>\n";   
                    }                    
                ?>      
            </select>
            <button type="submit">GO</button>
        </form>
        <?php
            //Check for form submission
            if($_POST){
                //var_dump($_POST);
                
                if($_POST['category']=='all'){
                    //user did not select an item (viewing all)
                    $q = "SELECT title, description FROM pages";
                }else{
                    //user selected an item (not viewing all)
                    $categoryId = $_POST['category'];
                    $q = "SELECT title, description 
                          FROM pages 
                          WHERE category_id = $categoryId";
                }  
                //echo $q;
                //exit();
                
                //Execute the query
                //$r = mysqli_query($dbc, $q);
                $stmt = $dbc->query($q);
                $page_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                //Check the number of rows and display 
                //$cnt = mysqli_num_rows($r);
                //echo "<h2>Total pages: $cnt</h2>";
                
                //Display data in HTML table, but only if we have rows
                //if($cnt>0){
                    //start the table
                    $output = "<table> 
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                    </tr>";
                    //loop every record and display data
                    foreach($page_list as $row ){
                         $output.= "<tr>
                                      <td>{$row['title']}</td>
                                      <td>{$row['description']}</td>
                                    </tr>";
                    }
                    //end the table
                    $output .="</table>";
                    //$output = $output . "</table>";
                    
                    echo $output;
                    
                //}
                
                
                
            }//End of post submission check
        ?>
        
        
    </body>
</html>
