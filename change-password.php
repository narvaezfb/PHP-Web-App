<?php
$title = "Change password";
include "./includes/header.php";
//if user is not registered
if (!isset($_SESSION['user']))
{
    //display a friendly message
    $_SESSION['message'] = "You need to sign in as admin or salesperson to change password";
    redirect("./sign-in.php");
}
if($_SERVER["REQUEST_METHOD"] == "GET" || isset($_POST['reset']))
    {
    //default mode when the page loads the first time
    //can be used to make decisions and initialize variables
       
        $password = "";
        $confirmPassword = "";
        $output = "";
        
}//when the page recieve the data from the user
else if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        $password = $_POST["password"]; // Saves password
        $confirmPassword = $_POST["confirmPassword"];//confirm the password
        $output = ""; // Clears output of any messages.

        //if password was not entered
        if (!isset($password) || $password == "")
        {
            $output .= "You did not enter a password</br>";
            $password = "";
            $confirmPassword = "";
        }
        //if password is less than 3 characters
        elseif (strlen("$password") < MIN_CHARACTER_LENGHT)
        {
            $output .= "Password should be at least 3 characters in length .</br>";
            $password = "";
            $confirmPassword = "";
        }
        //if password and confirm password are not the same
        elseif (strcmp($password, $confirmPassword))
        {
            $output .= "Passwords did not match</br>";
            $password = "";
            $confirmPassword = "";
        }
        // if everything is okay we can proceed
        if($output == "")
        {
            //call the function update password
            update_Password($user, $password);
            //redirect to the dashboard page
            redirect("./dashboard.php"); 
            //send a friendly message
            $_SESSION['message'] = "Password was succesfully updated";           
        }
       
        
    }
?>

<form class="form-signin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ">

    <h1 class="h3 mb-3 font-weight-normal">Password Update</h1>
    <input type="password" name="password" value="<?php echo $password; ?>" class="form-control" placeholder="Password" required>
    <input type="password" name="confirmPassword" value="<?php echo $confirmPassword; ?>" class="form-control" placeholder="confirm Password" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Change password</button>
    <?php
    echo "<p>" . $output . "</p>"; //display the output
    
    ?>
</form>
