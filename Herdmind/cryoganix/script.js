/**
 * The script for the registration page
 * Created by Blue Husky Studios for Herdmind. Copyright ©2013 Creative Commons 3.0 BY-SA
 * 
 * @author Kyli Rouge
 * @since 2013-05-30
 */

 function validateInput(jQElement, validationFxns, validationOutjQEs, output)
{
    var v = jQElement.val();
	if (!v)
		v = "";
	var good = true;
	if(Object.prototype.toString.call(validationFxns) === '[object Array]') // If validationFxns is an array
	{
		good = true;
		for(i = 0; i < validationFxns.length; i++)
		{
			if (!validationFxns[i](v))
			{
				good = false
				if (output)
					validationOutjQEs[i].addClass("bad");
			}
			else if (output)
				validationOutjQEs[i].removeClass("bad");
		}
	}
	else // just one function
	{
		good = validationFxns(v);
		if (good && output)
			validationOutjQEs.removeClass("bad");
		else if (output)
			validationOutjQEs.addClass("bad");
	}
	if (good && output)
		jQElement.removeClass("bad");
	else if (output)
		jQElement.addClass("bad");
	return good;
}

function validateEmail(output)
{
    return validateInput(
			$("#email"),
			function(val){return val.match(/.+@.+\..+/)},//Any number of characters, followed by an @, followed by any number of characters, followed by a period, followed by an number of charactes
			$("#email_needs_valid"),
			output
	);
}

function validateUser(output)
{
    return validateInput($("#user"),
			[
				function(val){return val.length > 0 && val.length <= 16;},//between 1 and 16 characters, inclusive
				function(val){return !val.match(/ /);}//no spaces
			],
			[
				$("#user_needs_length"),
				$("#user_needs_spaceless")
			],
			output
	);
}

function validatePass(output)
{
    return validateInput(
			$("#pass"),
			function(val){return val.match(/.{6}/);},//at least 6 characters
			$("#pass_needs_length"),
			output
	);
}

function validatePass2(output)
{
    return validateInput(
			$("#pass2"),
			function(val){return val == $("#pass").val();},//the same as the original password
			$("#pass2_needs_equal"),
			output
	);
}

function validateForm()
{
    var good;
    good = validateEmail(false);
    good = validateUser(false) && good;
    good = validatePass(false) && good;
    good = validatePass2(false) && good;
    $("#submit").prop("disabled", !good);
}

function evalPass()
{
    var p = $("#pass");
    var username = $("#user").val();
    var eMail = $("#email").val();
    var v = p.val();
	if (v == null)
		v = "";
    var strength = v.length;
    
    var strArray = [];
    var letterStrength = function(letter)
        {
            if (letter in strArray)
                return strArray[letter] /= 2;
            else
            {
                if (/\s/.test(letter))
                    strArray[letter] = 8;
                else if (letter == letter.toUpperCase() || !isNaN(letter))
                    strArray[letter] = 6;
                else
                    strArray[letter] = 2;                
            }
            return strArray[letter];
        };
    for(i=0; i < v.length; i++)
    {
        strength += (letterStrength(v[i]));
    }
    
    var vlc = v.toLowerCase();
    if (
           /password/.test(vlc)
        || /^(0?1?2?3?4?5?6?7?8?9?0?)$|^(0?9?8?7?6?5?4?3?2?1?0?)$/.test(vlc) // it's just a series of consecutive numbers
        )
            strength = 0;
    else if (
               (username && vlc.indexOf(username.toLowerCase()) !== -1)
            || (eMail    && vlc.indexOf(   eMail.toLowerCase()) !== -1)
            )
        strength /= 4;
    
    var strengthWord = "";
    if (strength >= 100)
        strengthWord = "Unbreakable";
    else if (strength >= 50)
        strengthWord = "Strong";
    else if (strength >= 20)
        strengthWord = "Average";
    else if (strength >= 5)
        strengthWord = "Weak";
    else
        strengthWord = "Obvious";
    
    $("#pass_needs_strength").css("display", "block");
	if (strength < 20)
		$("#pass_needs_strength").addClass("bad");
	else
		$("#pass_needs_strength").removeClass("bad");
	if (strength >= 50)
		$("#pass_needs_strength").addClass("good");
	else
		$("#pass_needs_strength").removeClass("good");
	
    $("#pass_meter_strength").val(strength);
    $("#pass_label_strength").text(strengthWord/* + " (" + strength + ")"*/);
}

if(window.attachEvent)
    window.attachEvent('onload', initializeLiveValidation);
else if(window.addEventListener)
    window.addEventListener('load', initializeLiveValidation, true);
//validateForm();
//$("#submit").prop("disabled", true);

function initializeLiveValidation()
{
	$("#register").keyup(validateForm);
	$("#register").change(validateForm);

	$("#email").keyup(validateEmail); $("#email").change(validateEmail); $("#email").keyup(validateForm); $("#email").change(validateForm);
	$("#user" ).keyup(validateUser ); $("#user" ).change(validateUser ); $("#user" ).keyup(validateForm); $("#user" ).change(validateForm);
	$("#pass" ).keyup(validatePass ); $("#pass" ).change(validatePass ); $("#pass" ).keyup(validateForm); $("#pass" ).change(validateForm); $("#pass").keyup(evalPass); $("#pass").change(evalPass);
	$("#pass2").keyup(validatePass2); $("#pass2").change(validatePass2); $("#pass2").keyup(validateForm); $("#pass2").change(validateForm);
	
	validateForm();
}