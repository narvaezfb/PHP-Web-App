<?php
/*
*Name: Fabian Narvaez
*Date: 2020-10-11
*Course Code Webd 3201
*/
$title = "Calls";
include "./includes/header.php";

//check if the session has started if not it redirects to sign in page
if(!isset($_SESSION['user']))
{
    $_SESSION['message'] = "You need to sign in as admin or salesperson to create a call record";
    redirect("./sign-in.php");
}
else
{
    if($_SERVER["REQUEST_METHOD"] == "GET" || isset($_POST['Clear']))
    {
        //default mode when the page loads the first time
        //can be used to make decisions and initialize variables
        $clientEmail = "";
        $time = "";
        $output = "";
        
    } //if the form is in post mode
    else if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //set the variables to the values of the form 
        $clientEmail = trim($_POST["clientEmail"]); 
        $time = trim($_POST["timeOfTheCall"]);;
        $output = "";

        //validate that the client exists in records
        $result = client_select($clientEmail);
        if ( pg_fetch_result($result, "clientEmail") <> "" )
        {
            //if true create a new record by calling the function addcallrecord
            $clientId = client_id($clientEmail);
            //add the record client id and time
            addCallRecord($clientId, $time);
            $output = "Call record was succesfully created";
            $clientEmail = "";
            $time = "";
        } 
        //if not display a friendly message
        else
        {
            $output = "the client entered does not exists in our records";
        }
    
    }
}
?>

<div style="max-width: 1200px; margin: 0 auto; padding:10px">
    <div class="row">
        <form class="form-signin" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ">

        <h1 class="h3 mb-3 font-weight-normal">Create a call record</h1>


        <label for="Client's call" class="sr-only">Client's call</label>
        <input type="text" name="clientEmail" value="<?php echo $clientEmail; ?>" class="form-control" placeholder="Client" required autofocus>

        <label for="Time" class="sr-only">Time of the Call</label>
        <input type="text" name="timeOfTheCall" value="<?php echo $time; ?>" class="form-control" placeholder="Time" required autofocus>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Create a Call</button>
        <?php
            echo "<p>" . $output . "</p>"; //display the output
        ?>
        </form>
    </div> 
     
    <div class="row">
        <h2>Calls Table</h2>
            <?php
                //display table calls
                display_table_calls($userId, $user_type);
            ?>
    </div>
</div>
<?php
include "./includes/footer.php";
?> 