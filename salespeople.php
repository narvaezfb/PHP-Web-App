<?php
/*
*Name: Fabian Narvaez
*Date: 2020-10-11
*Course Code Webd 3201
*/
$title = "Registration Page";
include "./includes/header.php";
//check if the user is admin otherwise redirect to sign in page
if ($_SESSION['user_type'] != ADMIN)
{
    //unset session user
    unset($_SESSION['user']);
    //display a friendly message
    $_SESSION['message'] = "You need to sign as a admin user in order to log into sales people registration";
    //redirect to the sign in page 
    redirect("./sign-in.php");
}
else
{
    if($_SERVER["REQUEST_METHOD"] == "GET" || isset($_POST['Clear']))
    {
        //default mode when the page loads the first time
        //can be used to make decisions and initialize variables
        $NewEmail = "";
        $NewPassword = "";
        $first_name = "";
        $last_name = "";
        $created ="";
        $last_time_user_logged="";
        $extension="";
        $user_type="";
        $output = "";
    }
    else if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $NewEmail = trim($_POST["NewEmail"]); 
        $NewPassword = $_POST["NewPassword"]; 
        $first_name = trim($_POST["first_name"]); 
        $last_name = trim($_POST["last_name"]); 
        $created = date("Y-m-d",time());
        $last_time_user_logged= date("Y-m-d",time());
        $extension = trim($_POST["extension"]);
        $user_type = "s";
        $output = ""; 
        $output = ""; // Clears output of any messages.

        //retrieve email user for validation purposes 
        $result = salesperson_select($NewEmail);

        //check if the value was inserted
        if (!(filter_var($NewEmail, FILTER_VALIDATE_EMAIL)))
        {
            $output .= $NewEmail . " is not a valid Email. Please try again.</br>";
            $NewEmail = "";
        }//validate if the email is not already in use
        else if ( pg_fetch_result($result, "email") <> "" )
            {
                $output .= "This email is already in use. Please try again.</br>";
                $NewEmail = "";
            }

        //check if the value was inserted
        if (!isset($first_name) || $first_name == "")
        {
            $output .= "You did not enter your first name</br>";
        }//check if the name is not numeric
        elseif (is_numeric($first_name))
            {
                $output .= "First name cannot contain numbers.</br>";
                $first_name = "";
            }

        //check if the value was inserted
        if (!isset($last_name) || $last_name == "")
        {
            $output .= "You did not enter your last name</br>";
        }//check if the name is not numeric
        elseif (is_numeric($last_name))
            {
                $output .= "Last name cannot contain numbers.</br>";
                $last_name = "";
            }

        //check if password is inserted
        if (!isset($NewPassword) || $NewPassword == "")
        {
            $output .= "You did not enter a password</br>";
        }

        //check if extension number is inserted
        if (!isset($extension) || $extension == "")
        {
            $output .= "You did not enter the extension</br>";
        }//check if the value is numeric
        elseif (!is_numeric($extension))
            {
                $output .= "extension number is not numeric.</br>";
                $extension = "";
            }

        //if it passes validation
        if ( $output == "" )
        {
        // Adds information to db users
            addNewSalesperson($NewEmail, $NewPassword, $first_name, $last_name, $created, $last_time_user_logged, $extension, $user_type);
            $output ="Sales person has been succesfully created";

            $NewEmail = "";
            $NewPassword = "";
            $first_name = "";
            $last_name = "";
            $created ="";
            $last_time_user_logged="";
            $extension="";
            $user_type="";

        } // value can not be created
        else
        {
            $output .="Sales person could not be created";
        }
    }
}

?>
<div style="max-width: 1200px; margin: 0 auto; padding:10px">
    <div class="row">
        <form class="form-signin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ">

            <h1 class="h3 mb-3 font-weight-normal">Registration</h1>

            
            <label for="Email" class="sr-only">Email</label>
            <input type="email" name="NewEmail" value="<?php echo $NewEmail; ?>" class="form-control" placeholder="Email address" required autofocus>
            
            <label for="First Name" class="sr-only">First Name</label>
            <input type="text" name="first_name" value="<?php echo $first_name; ?>" class="form-control" placeholder="First Name" required autofocus>

            <label for="Last Name" class="sr-only">Last Name</label>
            <input type="text" name="last_name" value="<?php echo $last_name; ?>" class="form-control" placeholder="Last Name" required autofocus>
            

            <label for="password" class="sr-only">Password</label>
            <input type="password" name="NewPassword" value="<?php echo $NewPassword; ?>" class="form-control" placeholder="Password" required >
            
            
            <label for="Extension" class="sr-only">Extension</label>
            <input type="number" name="extension" value="<?php echo $extension; ?>" class="form-control" placeholder="Extension" required autofocus>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>

            <?php
            echo "<p>" . $output . "</p>"; //display the output
            ?>
            
        </form>
    </div>

<div class="row">
<h2>Sales people Table</h2>
<?php
display_table_Salespeople();
?>
</div>
</div>

<?php
include "./includes/footer.php";
?> 
