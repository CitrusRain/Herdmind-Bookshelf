<?php
/*
 * Initiates a database connection and provides a global variable $db_connection so other files can access it
 */


/*
$mysql_host = "localhost";
$mysql_database = "citrus_mane";
$mysql_user = "citrus_mane";
$mysql_password = "trainwreck27";
*/

//These are the login details for the development database copy.
$mysql_host = "localhost";
$mysql_database = "citrus_BETABASE";
$mysql_user = "citrus_develop";
$mysql_password = "hejustcalledme";

//Forum tables' prefix
global $forumprefix;
$forumprefix = "zforums";



//Create database connection for website
global $db_connection;
$db_connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password);
mysqli_select_db($db_connection, $mysql_database);

if (mysqli_connect_errno($db_connection)) {
	echo "Error connection to database: " . mysqli_connect_error();
}

//Set other global parameters 

//These make sure comments are sorted.
global $ThreadBoardID_Topics;
global $ThreadBoardID_Fanfacts;
global $ThreadBoardID_Fanworks;
global $ThreadBoardID_Profiles;

$ThreadBoardID_Topics = 0;
$ThreadBoardID_Fanfacts = 3;
$ThreadBoardID_Fanworks = 0;
$ThreadBoardID_Profiles = 2;




?>