<?php
/*
*Name: Fabian Narvaez
*Date: 2020-09-11
*Course Code Webd 3201
*/
$title = "Sign In";
include "./includes/header.php";

//check if session has started and it takes user straight to dashboard page
if (isset($_SESSION['user']))
{   
     redirect("./dashboard.php");
}
//otherwise
else
{
    if($_SERVER["REQUEST_METHOD"] == "GET" || isset($_POST['reset']))
    {
    //default mode when the page loads the first time
    //can be used to make decisions and initialize variables
        $email = "";
        $password = "";
        $output = "";
        
    }
    else if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $email = trim($_POST["email"]); // Trims the email and initialize
        $password = $_POST["password"]; // Saves password
        $output = ""; // Clears output of any messages.
        $date = date("Y-m-d",time());
        
        
        //check if email was entered
        if (!isset($email) || $email == "")
        {
            $output = "Must enter email</br>";
            $password = "";
        }
        //checks if password was entered
        if (!isset($password) || $password == "")
        {
            $output .= "Must enter password";
            $password ="";
        }
        //if values entered are entered procced 
        if($output == "")
        {
            //call my user_authenticate function and if values are correct then procced
            if(user_authenticate($email, $password))
            {
                //set user session equal to email
                $_SESSION['user'] = $email; 

                //Get the user id for table relationship purposes
                $userId = user_id($email);
                $_SESSION['userId'] = $userId;


                //retrieve the last user logged in 
                $lastUserLoggedIn = user_last_login($email);

                //display a welcome message
                $_SESSION['message'] = "Welcome user " . $_SESSION['user'] . " Last time you logged in was in  " . $lastUserLoggedIn;

                //update last user logged in
                user_update_login($email, $date);

                //set the user type to user_type session by retriving the type from the database matching the email of the person that is signed in
                $user_type = user_type($email);
                $_SESSION['user_type'] =$user_type;

                $userName = user_selectName($email);
                $_SESSION['userName'] = $userName;

                //append the date and user's email to Date_log.txt
                $handle = fopen('./includes/Date_log.txt','a');
                fwrite($handle,"\r\nSign in success at " . "$date" . " User " . " $email ");
                fclose($handle);
                redirect("./dashboard.php");//send the user to dashboard page
                
            }
            //otherwise display a message about the incorrect authentication
            else
            {
                $output = "user did not authenticate correctly";
                $password="";
            }
        }
    }
    
}
?>   
<form class="form-signin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <p> <?php echo $message; ?> </p>

    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

    <label for="inputEmail" class="sr-only">Email address</label>

    <input type="email" name="email" value="<?php echo $email; ?>" class="form-control" placeholder="Email address" required autofocus>

    <label for="inputPassword" class="sr-only">Password</label>

    <input type="password" name="password" value="<?php echo $password; ?>" class="form-control" placeholder="Password" required>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <?php
    echo "<p>" . $output . "</p>"; //display the output
    ?>
</form>

<?php
include "./includes/footer.php";
?>    