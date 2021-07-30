<?php
/*
*Name: Fabian Narvaez
*Date: 2020-10-11
*Course Code Webd 3201
*/

$title = "Clients";
include "./includes/header.php";

//check if the session has started if not it redirects to sign in page
if (!isset($_SESSION['user']))
{
    $_SESSION['message'] = "You need to sign in as admin or salesperson to create a client";
    redirect("./sign-in.php");
}
else
{
    if($_SERVER["REQUEST_METHOD"] == "GET" || isset($_POST['Clear']))
    {
        //default mode when the page loads the first time
        //can be used to make decisions and initialize variables
        $clientEmail = "";
        $first_name = "";
        $last_name = "";
        $phoneNumber="";
        $salesperson="";
        $img_dir = "";
        $output = "";
    }
    //if the form is in post mode
    else if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $clientEmail = trim($_POST["clientEmail"]); 
        $first_name = trim($_POST["first_name"]); 
        $last_name = trim($_POST["last_name"]); 
        $phoneNumber = trim($_POST["phoneNumber"]);
        $output = "";
       //file name plus the directory where the images will be stored
        $img_dir = 'imagesUploaded/'.$_FILES['uploadfileName']['name'];
        $fileName = $_FILES['uploadfileName']['name'];

        //if user is admin
        if($_SESSION['user_type'] == "a")
        {
            //retrieve the user id from the database and store it as a foreign key
            $user = $_POST['salespeople'];
            $salesperson= user_id($user);
        }
        //user will be saved as salesperson
        else
        {
            $salesperson= $userId;
        }
       

        //check if the first name was inserted
        if(!isset($first_name) || $first_name == "")
        {
            $output .= "You did not enter your first name</br>";
        }
        //check is the user inserted a number
        elseif (is_numeric($first_name))
        {
            $output .= "First name cannot contain numbers.</br>";
            $first_name = "";
        }
        //check if the last name was inserted
        if (!isset($last_name) || $last_name == "")
        {
            $output .= "You did not enter your last name</br>";
        }
        //check is the user inserted a number
        elseif (is_numeric($last_name))
        {
            $output .= "Last name cannot contain numbers.</br>";
            $last_name = "";
        }

        //validate email 
        $result = client_select($clientEmail);
        if (!(filter_var($clientEmail, FILTER_VALIDATE_EMAIL)))
        {
            $output .= $clientEmail . " is not a valid Email. Please try again.</br>";
            $clientEmail = "";
        }
        //check if the email is not already in use
        else if ( pg_fetch_result($result, "clientEmail") <> "" )
        {
            $output .= "This email is already in use. Please try again.</br>";
            $clientEmail = "";
        }  


        //validate if the phone number is inserted
        if (!isset($phoneNumber) || $phoneNumber == "")
        {
            $output .= "You did not enter the extension</br>";
        }
        //validate the values is numeric
        elseif (!is_numeric($phoneNumber))
        {
            $output .= "extension number is not numeric.</br>";
            $phoneNumber = "";
        }
        
        //file validation
        if($_FILES['uploadfileName']['error'] != 0)
        {
            $output .= "Problem uploading your file";
            $img_dir ="";
        }
        else if ($_FILES['uploadfileName']['type'] != "image/jpeg" && $_FILES['uploadfileName']['type'] != "image/pjpeg" 
        && $_FILES['uploadfileName']['type'] != "image/gif" && $_FILES['uploadfileName']['type'] != "image/png")
        {
            $output .= "your files must be type png, pjpeg, gif, jpeg";
            $img_dir ="";
        }
        //if it passes input validation
        if ( $output == "" )
        {
        // Adds information to clients
            addNewClient($clientEmail, $first_name, $last_name, $phoneNumber, $salesperson, $img_dir);
            $output="Client has been succesfully created";
            $clientEmail="";
            $first_name="";
            $last_name="";
            $phoneNumber="";
            $salesperson="";
            $img_dir ="";
            //move the uploaded file to the folder where all the images will be stored
            move_uploaded_file($_FILES['uploadfileName']['tmp_name'],"./imagesUploaded/".$fileName);
        }
    }         
}
?>
<div style="max-width: 1200px; margin: 0 auto; padding:10px">
<div class="row">
<form  id="uploadform" class="form-signin" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ">

<h1 class="h3 mb-3 font-weight-normal">Client Registration</h1>


<label for="First Name" class="sr-only">First Name</label>
<input type="text" name="first_name" value="<?php echo $first_name; ?>" class="form-control" placeholder="First Name" required autofocus>

<label for="Last Name" class="sr-only">Last Name</label>
<input type="text" name="last_name" value="<?php echo $last_name; ?>" class="form-control" placeholder="Last Name" required autofocus>

<label for="Email" class="sr-only">Email</label>
<input type="email" name="clientEmail" value="<?php echo $clientEmail; ?>" class="form-control" placeholder="Email address" required autofocus>


<label for="Extension" class="sr-only">Phone Number</label>
<input type="number" name="phoneNumber" value="<?php echo $phoneNumber; ?>" class="form-control" placeholder="Phone Number" required autofocus>
<?php
//if user is type admin then a list of salespeople must appear in the form 
if($_SESSION['user_type'] == "a")
{
echo '<select name="salespeople" id="salespeople" >';
    
    echo '<option> Sales Person </option>';
   // <?php

        $result = salespeopleList();
        while($row = pg_fetch_assoc($result))
        {
            echo '<option>'.$row['email'].'</option>';
                
        }
    //
echo'</select>';
}
?>
<label for="uploadfileId"> Select logo for upload </label></br>
<input name="uploadfileName" type="file" id="uploadfileId" />
<button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
<?php
    echo "<p>" . $output . "</p>"; //display the output
    
?>
</form>
</div>
    <div class="row">
        <h2>Clients Table</h2>
            <?php
            //display table clients
                display_table_clients($userId , $user_type);
            ?>
    </div>
</div>
<?php
include "./includes/footer.php";
?> 