<?php
/*
*Name: Fabian Narvaez
*Date: 2020-09-11
*Course Code Webd 3201
*/
$title = "WEBD 3201 Home Page";
include "./includes/header.php";

//check if session has started otherwise if takes the user to sign-in page
if (!isset($_SESSION['user']))
{
    redirect("./sign-in.php");
}
?>

<h1 class="cover-heading">Cover your page.</h1> <br>
<p> <?php echo $message; ?> </p>
<!--<p class="lead">Cover is a one-page template for building simple and beautiful home pages. Download, edit the text, and add your own fullscreen background photo to make it your own.</p>
<p class="lead">-->
    <a href="#" class="btn btn-lg btn-secondary">Learn more</a>
</p>

<?php
include "./includes/footer.php";
?>    