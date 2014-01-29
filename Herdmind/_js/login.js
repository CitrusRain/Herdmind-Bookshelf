var loginUsername;
if (isJQueryLoaded())
	loginUsername = $("#LOGIN_USERNAME");
else
	loginUsername = document.getElementById("LOGIN_USERNAME");

loginUsername.change(function()
{
	loginUsername.css("background", "red");
}
);