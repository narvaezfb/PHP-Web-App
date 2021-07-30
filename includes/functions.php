<?php
/*
Fabian Narvaez 
2020-10-18
WEBD 3201
Functions page
*/
//Redirect to redirect to another URL
function redirect($url)
{
    header("Location:".$url);
    ob_flush();
}
//the function will display the elements of the post array 
 function display_form( 
       $myArray= array(
            array( 
                "type" => "text",
                "name" => "first_name",
                "value" => "",
                "label" => "First Name"
            ),
            array(
                "type" => "text",
                "name" => "last_name",
                "value" => "",
                "label" => "Last Name"
            ),
            array(
                "type" => "text",
                "name" => "email",
                "value" => "",
                "label" => "Email"
            ),
            array(
                "type" => "number",
                "name" => "extension",
                "value" => "",
                "label" => "Extension"
             )
         )
    )
    {
    //retunr the array
      return print_r($myArray);
    }

    function display_formPassword(
        $myArrayPassword = array(
            array(
                "type" => "password",
                "name" => "password",
                "value" => "",
                "label" => "New Password"
            ),
            array(
                "type" => "password",
                "name" => "confirm",
                "value" => "",
                "label" => "Re-type password"
            ),
        )
    )
    {
        return print_r($myArrayPassword);
    }

?>