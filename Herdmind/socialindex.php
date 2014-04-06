<!DOCTYPE HTML>
<!--
A user profile page

This page is copyright Herdmind.net ©2013
-->
<?php

include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/RetreiveData.php";   // File that returns data in XML format
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second

$user = isset($_GET["user"]) && is_numeric($_GET["user"]) ? max($_GET["user"], 0) : 0;

?>
<HTML>
<HEAD>
<?php
buildDefaultHeadContent("Triple-type posting", "Trying a thing", array("Descriptive", "Keywords"));
?>

<STYLE>
DT {
	font-weight: bold;
}
	DT.major,
	DT.major+DD {
		font-size: 2em;
		text-align: center;
		text-indent: 0;
	}
	DT.inline {
		float: left;
	}
	DT.colon::after {
		content: ":";
		padding-right: 0.5em;
	}
	DT.noTerm {
		display: none;
	}
	DD {
		font-weight: normal;
		margin: 0;
		padding: 0;
		text-indent: 2em;
	}

FIGURE.topic {
	border-radius: 0.5em;
	display: table;
	margin: 0;
	width: 100%;
}
	FIGURE.topic>* {
		display: table;
		vertical-align: top;
		}@media all and (max-width: 40em) { FIGURE.topic>* {
			display: block;
			margin: 0.5em;
		}
	}
	FIGURE.topic>IMG {
		border: 0.1em solid #FFF;
		border-radius: 0.5em;
		background: rgba(255,255,255, 0.5);
		float: left;
		margin: 0 1em 0 0;
		width: 15%;
		min-width: 1in;
		}@media all and (max-width: 40em) { FIGURE.topic>IMG {
			float: none;
			margin: auto;
			max-width: 100%;
			width: 30em;
		}
	}
/*	FIGURE.topic>*:last-child {
		clear: both;
	}*/
#FACTS {
	margin-top:0.5em;
}
#FACTS:target {
	background: transparent;
	color:inherit;
}
</STYLE>
</HEAD>



<?php
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>


  <style type="text/css">
  html, body { margin: 0; padding: 0; }
  .hide { display: none;}
  .show { display: block;}
  </style>
  <script type="text/javascript">
  /**
   * Global variables to hold the profile and email data.
   */
   var profile, email;

  /*
   * Triggered when the user accepts the sign in, cancels, or closes the
   * authorization dialog.
   */
  function loginFinishedCallback(authResult) {
    if (authResult) {
      if (authResult['error'] == undefined){
        toggleElement('signin-button'); // Hide the sign-in button after successfully signing in the user.
        gapi.client.load('plus','v1', loadProfile);  // Trigger request to get the email address.
      } else {
        console.log('An error occurred');
      }
    } else {
      console.log('Empty authResult');  // Something went wrong
    }
  }

  /**
   * Uses the JavaScript API to request the user's profile, which includes
   * their basic information. When the plus.profile.emails.read scope is
   * requested, the response will also include the user's primary email address
   * and any other email addresses that the user made public.
   */
  function loadProfile(){
    var request = gapi.client.plus.people.get( {'userId' : 'me'} );
    request.execute(loadProfileCallback);
  }

  /**
   * Callback for the asynchronous request to the people.get method. The profile
   * and email are set to global variables. Triggers the user's basic profile
   * to display when called.
   */
  function loadProfileCallback(obj) {
    profile = obj;

    // Filter the emails object to find the user's primary account, which might
    // not always be the first in the array. The filter() method supports IE9+.
    email = obj['emails'].filter(function(v) {
        return v.type === 'account'; // Filter out the primary email
    })[0].value; // get the email from the filtered results, should always be defined.
    displayProfile(profile);
  }

  /**
   * Display the user's basic profile information from the profile object.
   */
  function displayProfile(profile){
    document.getElementById('name').innerHTML = profile['displayName'];
    document.getElementById('pic').innerHTML = '<img src="' + profile['image']['url'] + '" />';
    document.getElementById('email').innerHTML = email;
    toggleElement('profile');
  }

  /**
   * Utility function to show or hide elements by their IDs.
   */
  function toggleElement(id) {
    var el = document.getElementById(id);
    if (el.getAttribute('class') == 'hide') {
      el.setAttribute('class', 'show');
    } else {
      el.setAttribute('class', 'hide');
    }
  }
  </script>
  <script src="https://apis.google.com/js/client:plusone.js" type="text/javascript"></script>

  <div id="signin-button" class="show">
     <div class="g-signin"
      data-callback="loginFinishedCallback"
      data-approvalprompt="force"
      data-clientid="116168242556-5g0o7gc07o8a5clbekbntpgvscqtt41a.apps.googleusercontent.com"
      data-scope="https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read"
      data-height="short"
      data-cookiepolicy="single_host_origin"
      >
    </div>
    <!-- In most cases, you don't want to use approvalprompt=force. Specified
    here to facilitate the demo.-->
  </div>

  <div id="profile" class="hide">
    <div>
      <span id="pic"></span>
      <span id="name"></span>
    </div>

    <div id="email"></div>
  </div>


<SECTION id='comments'>

Todo:<br/>
Pull the topic OP/fanfact being commented on.<br/>
Only pull one item per thread.<br/>
Allow for more ways of pulling - Popular/Newest/Friend-based<br/>
Add the ability to have a "post new thread" box<br/>
Add "cards" from old landing page to the side.<br/>
etc.

<?php
/*

Make a place to make a thread with

*/
echo "
<form method='POST'>
		<textarea id='commentbox'></textarea>
		<button type='button' onclick='PostNew(\"".$fandom->fandomid."\")'>Submit a Shitpost</button>
	</form>
";

/*

Get and Print the comments

*/

$comments = GetCommentsFeed("primary");
echo buildComments($comments);



?>
</SECTION>



<?php
buildFooter();
?>
</BODY>
</HTML>
