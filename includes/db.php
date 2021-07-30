<?php   
    /*
    *Name: Fabian Narvaez
    *Date: 2020-09-11
    *last modified: 2020-11-16
    *Course Code Webd 3201
    */
    //This function connects me to the database
    function db_connect()
    {
        return pg_connect("host=".DB_HOST." port=".DB_PORT." dbname=".DATABASE." user=".DB_ADMIN." password=".DB_PASSWORD);
    }
    
    //prepared statement  that allows me to search for user's email
    function user_select($email)
    {
        $conn = db_connect();
        $stmt1= pg_prepare($conn, "user_name", 'SELECT * FROM users WHERE email = $1');
        $result = pg_execute($conn, "user_name", array($email));
        $user = pg_fetch_assoc($result, 0);
        return $user; //return user
    }
    //user name
    function user_selectName($email)
    {
        $conn = db_connect();
        $stmt1= pg_prepare($conn, "user_name", 'SELECT first_name FROM users WHERE email = $1');
        $result = pg_execute($conn, "user_name", array($email));
        $user = pg_fetch_result($result, 0,0);
        return $user; //return user
    }
    //function to retrive the user_type since there are different ones such as admin and salesperson
    function user_type($email)
    {
        $conn = db_connect();
        $sql = "SELECT user_type FROM users
        WHERE email = '$email'";
        $result= pg_query( $conn,$sql );
        $records = pg_fetch_result($result, 0, 0);

        return $records;//return records
    }

    function user_id($email)
    {
        $conn = db_connect();
        $sql = "SELECT id FROM users
        WHERE email = '$email'";
        $result= pg_query( $conn,$sql );
        $records = pg_fetch_result($result, 0, 0);

        return $records;//return records
    }

     //prepared statement  that allows me to authenticate validating email and password
    function user_authenticate($email, $password)
    {
         $isValid = false;
         $conn = db_connect();
         $stmt1= pg_prepare($conn, "user_login", 'SELECT * FROM users WHERE email = $1');
         $result = pg_execute($conn, "user_login", array($email));
         $user = pg_fetch_assoc($result);
 
         //use this method for the password encrypted
         if(password_verify($password, $user['password']))
         {
             $isValid = true; // return true if email and password are correct
         }
         else
         {         
             $isValid = false; // return false if email and password are correct
         }
 
         return $isValid; // return true or false depending the validation
    }
     // prepared statement-function to update the last time user logged
    function user_update_login($email, $date)
    {
        $conn = db_connect();
        date_default_timezone_set('Canada/Central');
        $date = date('h:i:s a');
        $stmt2 = pg_prepare($conn, "user_update_login", 'UPDATE users SET Last_time_user_logged = $1 WHERE email = $2');
        $result = pg_execute($conn, "user_update_login", array($date, $email));

    }
    //function to retrievete the last user login record of user
    function user_last_login($email)
    {
        $conn = db_connect();
        $sql = "SELECT Last_time_user_logged FROM users
        WHERE email = '$email'";
        $result= pg_query( $conn,$sql );
        $records = pg_fetch_result($result, 0, 0);

        return $records;//return records
    }

    //Clients functions
    //Retrieve client email from the database clients table
    
    function client_select($email)
    {
        $conn = db_connect();
        $sql = "SELECT clientEmail
        FROM clients
        WHERE clientEmail = '$email'";
        $result = pg_query($conn, $sql);

        return $result; //return the email retrived 
    }
    //Insert a new client into clients table
    function addNewClient($clientEmail, $first_name, $last_name, $phoneNumber, $salesperson, $fileName)
    {
        $conn = db_connect();
        //insert into the fields the following values
        $stmt3 = pg_prepare($conn, 'client_insert', 'INSERT INTO clients(clientEmail, clientFirstName, clientLastName, clientPhoneExtension, salespersonAssociated, img_dir)
                            VALUES ($1, $2, $3, $4, $5, $6)');
        $result = pg_execute($conn, 'client_insert', array($clientEmail, $first_name, $last_name, $phoneNumber, $salesperson, $fileName));

    }



    //retrieve the client id (primary key)
    function client_id($email)
    {
        //call db connect
        $conn = db_connect();
        $sql = "SELECT id FROM clients
        WHERE clientEmail = '$email'";
        $result= pg_query( $conn,$sql );
        $records = pg_fetch_result($result, 0, 0);

        return $records;//return records
    }



    //Salesperson functions
    //Retrieve salesperson email from the database users table
    function salesperson_select($email)
    {
        $conn = db_connect();
        $sql = "SELECT email
        FROM users
        WHERE email = '$email'";
        $result = pg_query($conn, $sql);

        return $result;//return the email retrived 
    }

   //Insert a new salesperson into users table
    function addNewSalesperson($NewEmail, $NewPassword, $first_name, $last_name, $created, $last_time_user_logged, $extension, $user_type)
    {
        $conn = db_connect();
        //insert into the fields the following values
        $stmt4 = pg_prepare($conn, 'salesperson_insert', 'INSERT INTO users(email, password, First_Name,Last_Name,Created,Last_time_user_logged,Phone_extension,User_type)
                            VALUES ($1, $2, $3, $4, $5, $6, $7, $8)');
        $result = pg_execute($conn, 'salesperson_insert', array($NewEmail, password_hash($NewPassword, PASSWORD_BCRYPT), $first_name, $last_name, $created, $last_time_user_logged, $extension, $user_type));

    }
    //retrieve the list of all the salespeople from the users table
    function salespeopleList()
    {
        $conn = db_connect();
        $sql = "SELECT email FROM users
        WHERE user_type = 's'";
        $result= pg_query( $conn,$sql );
        return $result;//return all salespeople users
    }
    //calls functions
    //Insert a new record into a calls table
    function addCallRecord($clientEmail, $time)
    {
        //insert the record by using the prepared statement function and pg execute
        $conn = db_connect();
        $stmt5 = pg_prepare($conn, 'call_insert', 'INSERT INTO calls(clientId, timeOfTheCall) VALUES ($1, $2)');
        $result = pg_execute($conn, 'call_insert', array($clientEmail, $time));
    }
    
    //update password
    function update_Password($email, $password)
    {
        $conn = db_connect();
        
        $stmt2 = pg_prepare($conn, "update_Password", 'UPDATE users SET password = $1 WHERE email = $2');
        $result = pg_execute($conn, "update_Password", array(password_hash($password, PASSWORD_BCRYPT), $email));

    }

    //display table clients 
    function display_table_clients($userId, $user_type)
    {
        //connect to the database
       $conn = db_connect();

        //adding some formatting
        echo "<div class=table-responsive>";
        echo "<table class=table table-striped table-sm>";
        echo "<tr> <td>ID</td><td> Client Email</td><td>First Name </td><td>Last Name </td><td>Phone Extension </td><td>Sales Person associated </td><td>Logo </td></tr>";
        

        //if user is admin
        if($user_type == "a")
        {
            $stmt1 = pg_prepare($conn, "client_count_forAdmin" ,'SELECT * FROM clients');
            $result1 = pg_execute($conn, "client_count_forAdmin", array( ));
            $numberOfResults = pg_num_rows($result1);
        }
        
        //if user is salespeople
        if($user_type == "s")
        {
            $stmt1 = pg_prepare($conn, "client_count_forSalespeopleassociated" ,'SELECT id, clientEmail, clientFirstName, clientLastName, clientPhoneExtension, salespersonAssociated, img_dir FROM clients WHERE salespersonAssociated = $1');
            $result1 = pg_execute($conn, "client_count_forSalespeopleassociated", array($userId));
            $numberOfResults = pg_num_rows($result1);
        }
        
        
        //set the number of pages based of the number of records divided by the limit of records
        $numberOfPages = ceil( $numberOfResults / RESULTS_PER_PAGE);

        //if page is not set then set the page equal to 1
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        //start the number of records
        $start = ($page - 1) * RESULTS_PER_PAGE;

        if($page <= 0)  
        {
            redirect("./clients.php");
        }
        else
        {
            $previous = $page - 1;
        } 
        $next = $page + 1;


        //retrieve the data depending the type of user
        if($user_type == "a")
        {
            $stmt1 = pg_prepare($conn, "client_select_forAdmin" ,'SELECT * FROM clients LIMIT $1 OFFSET $2');
            $result2 = pg_execute($conn, "client_select_forAdmin", array(RESULTS_PER_PAGE, $start));
           
        }
        
        //if user is salespeople
        if($user_type == "s")
        {
            $stmt1 = pg_prepare($conn, "client_select_forSalespeopleassociated" ,'SELECT id, clientEmail, clientFirstName, clientLastName, clientPhoneExtension, salespersonAssociated, img_dir FROM clients WHERE salespersonAssociated = $1 LIMIT $2 OFFSET $3');
            $result2 = pg_execute($conn, "client_select_forSalespeopleassociated", array($userId, RESULTS_PER_PAGE, $start));
            
        }

        //retrieve all the records
        while($row = pg_fetch_assoc($result2))
        {
            echo "<tr><td>" . $row['id'] . "</td> <td>". $row['clientemail']. "</td><td>". $row['clientfirstname']."</td><td>". $row['clientlastname']."</td><td> ". $row['clientphoneextension']."</td><td> ". $row['salespersonassociated']."</td><td> "."<img src='{$row['img_dir']}' width='40%' height='40%'>"."</td> </tr>";
        }
        echo "</table>";
        echo "</div>";

        echo '<nav aria-label="Page navigation example">
              <ul class="pagination">
              <li class="page-item"><a class="page-link" href="clients.php?page='.$previous.'">Previous</a></li>';
        
            for($i = 1; $i <= $numberOfPages; $i++) 
            {
                echo '<li class="page-item"><a class="page-link" href="clients.php?page='.$i.'">'.$i.'</a></li> '; 
            } 
       
        echo '<li class="page-item"><a class="page-link" href="clients.php?page='.$next.'">Next</a></li>';
        echo '</ul>';
        echo '</nav>';
        echo "</div>";

        
        
    }



    //display table salespeople
    function display_table_Salespeople()
    {
        //connect to the database
       $conn = db_connect();
        
       //adding some formatting
        echo "<div class=table-responsive>";
        echo "<table class=table table-striped table-sm>";
        echo "<tr> <td>ID</td><td> Sales person email</td><td>First Name </td><td>Last Name </td><td> Created </td><td>Last time user logged</td><td>Phone extension </td><td> User type</td></tr>";
       
       
           
        //retrieve the number of salespeople
        $stmt1 = pg_prepare($conn, "count_salespeople" ,'SELECT id, email, First_Name, Last_Name, Created ,Last_time_user_logged, Phone_extension, User_type FROM users WHERE  User_type = $1 ');
        $result1 = pg_execute($conn, "count_salespeople", array(SALESPERSON ));
        $numberOfResults = pg_num_rows($result1);
        
        //set the number of pages based of the number of records divided by the limit of records
        $numberOfPages = ceil( $numberOfResults / RESULTS_PER_PAGE);

        //if page is not set then set the page equal to 1
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        //start the number of records
        $start = ($page - 1) * RESULTS_PER_PAGE;

        if($page <= 0)  
        {
            redirect("./salespeople.php");
        }
        else
        {
            $previous = $page - 1;
        } 
        $next = $page + 1;

        //retrieve the records
        $stmt1 = pg_prepare($conn, "salespeople_select_all" ,'SELECT id, email, First_Name, Last_Name, Created ,Last_time_user_logged, Phone_extension, User_type FROM users WHERE  User_type = $1 LIMIT $2 OFFSET $3 ');
        $result2 = pg_execute($conn, "salespeople_select_all", array(SALESPERSON, RESULTS_PER_PAGE, $start ));

        //retrieve the data
        while($row = pg_fetch_assoc($result2))
        {
            echo "<tr><td>" . $row['id'] . "</td> <td>". $row['email']. "</td><td>". $row['first_name']."</td><td>". $row['last_name']."</td><td> ". $row['created']."</td><td> ". $row['last_time_user_logged']."</td><td>". $row['phone_extension']."</td><td>". $row['user_type']."</td> </tr>";
        }
     
        echo "</table>";
        echo "</div>";

        echo '<nav aria-label="Page navigation example">
              <ul class="pagination">
              <li class="page-item"><a class="page-link" href="salespeople.php?page='.$previous.'">Previous</a></li>';
        
            for($i = 1; $i <= $numberOfPages; $i++) 
            {
                echo '<li class="page-item"><a class="page-link" href="salespeople.php?page='.$i.'">'.$i.'</a></li> '; 
            } 
       
        echo '<li class="page-item"><a class="page-link" href="salespeople.php?page='.$next.'">Next</a></li>';
        echo '</ul>';
        echo '</nav>';
        echo "</div>";
    }

    function display_table_calls($salespersonAssociated, $user_type)
    {
        //connect to the database
       $conn = db_connect();
        
       //adding some formatting
        echo "<div class=table-responsive>";
        echo "<table class=table table-striped table-sm>";
        echo "<tr> <td> ID</td><td> Client ID </td><td>Time of the Call </td></tr>";
       
        //retrieve the number of records

        //if the user is admin count all the record from calls table
        if($user_type == 'a')
        {
            $stmt1 = pg_prepare($conn, "calls_count_forAdmins" ,'SELECT * FROM calls');
            $result1 = pg_execute($conn, "calls_count_forAdmins", array());
            $numberOfResults = pg_num_rows($result1);
        }
         //if the user is salesperson count the records found of that person  from calls table
        if($user_type == "s")
        {
            $stmt1 = pg_prepare($conn, "calls_count_salespeople" ,'SELECT calls.id, clientId, timeOfTheCall FROM calls inner join clients on calls.clientId = clients.id where clients.salespersonAssociated = $1');
            $result1 = pg_execute($conn, "calls_count_salespeople", array($salespersonAssociated));
            $numberOfResults = pg_num_rows($result1);
        }
       
        //set the number of pages based of the number of records divided by the limit of records
        $numberOfPages = ceil( $numberOfResults / RESULTS_PER_PAGE);

        //if page is not set then set the page equal to 1
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        //start the number of records
        $start = ($page - 1) * RESULTS_PER_PAGE;

        //previous and next variables for pages
        if($page <= 0)  
        {
            redirect("./calls.php");
        }
        else
        {
            $previous = $page - 1;
        }     
             
        $next = $page + 1;

        //retrieve therecords
        //if the user is admin then display all the records from calls table
        if($user_type == 'a')
        {
            $stmt1 = pg_prepare($conn, "calls_select_allForAdmins" ,'SELECT * FROM calls  LIMIT $1 OFFSET $2');
            $result2 = pg_execute($conn, "calls_select_allForAdmins", array( RESULTS_PER_PAGE, $start));
        }
       
        //if the user is salesperson then display all the records found that are related with that person from calls table
        if($user_type == 's')
        {
            $stmt1 = pg_prepare($conn, "calls_select_allSalespeople" ,'SELECT calls.id, clientId, timeOfTheCall FROM calls inner join clients on calls.clientId = clients.id where clients.salespersonAssociated = $1  LIMIT $2 OFFSET $3');
            $result2 = pg_execute($conn, "calls_select_allSalespeople", array($salespersonAssociated, RESULTS_PER_PAGE, $start));
        }

        
       
        //retrieve the data
        while($row = pg_fetch_assoc($result2))
        {
            echo "<tr><td>" . $row['id'] . "</td> <td>". $row['clientid']. "</td><td>". $row['timeofthecall']."</td></tr>";
        }
        echo "</table>";
        echo "</div>";
        echo '<nav aria-label="Page navigation example">
              <ul class="pagination">
              <li class="page-item"><a class="page-link" href="calls.php?page='.$previous.'">Previous</a></li>';
        
            for($i = 1; $i <= $numberOfPages; $i++) 
            {
                echo '<li class="page-item"><a class="page-link" href="calls.php?page='.$i.'">'.$i.'</a></li> '; 
            } 
       
        echo '<li class="page-item"><a class="page-link" href="calls.php?page='.$next.'">Next</a></li>';
        echo '</ul>';
        echo '</nav>';
        echo "</div>";
        
        echo "</div>";
    }
?>