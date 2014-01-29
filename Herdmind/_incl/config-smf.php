<?php

$mysql_host = "localhost";
$mysql_database = "citrus_BETABASE";
$mysql_user = "citrus_develop";
$mysql_password = "hejustcalledme";
global $forumprefix;

smf_db_initiate($mysql_host, $mysql_database, $mysql_user, $mysql_password, $forumprefix);

?>