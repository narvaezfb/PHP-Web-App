<?php
/*
*Name: Fabian Narvaez
*Last Date: modified: 2020-11-16
*Course Code Webd 3201
*/
///// user type//////
define ("ADMIN", 'a');
define ("SALESPERSON", 's');
define("AGENT",'a');
define("CLIENT",'c');
define("PENDING",'p');
define("DISABLED",'d');
///////Database///////////
define("DB_HOST",'localhost');
define("DATABASE",'users');
define("DB_ADMIN",'narvaezfb');
define("DB_PORT",'5432');

define("DB_PASSWORD",'Ecuador2020.');

//limit of records per page
define("RESULTS_PER_PAGE", 10);
//min character lenght for password
define("MIN_CHARACTER_LENGHT", 3)
?>