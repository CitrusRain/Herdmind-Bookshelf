<?php
/*

Starts the session, gets the subdomain
Initializes stuff.

*/

$fandom = array_shift(explode(".",$_SERVER['HTTP_HOST']));

if($fandom == 'beta')
{
	$fandom = $_GET["subdomain"];
	if($fandom != 'pony' and $fandom != 'tardis')
	{
		$fandom = '';
	}
}


?>