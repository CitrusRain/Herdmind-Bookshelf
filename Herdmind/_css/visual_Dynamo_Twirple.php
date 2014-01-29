<?PHP
include "dynamoThemeGenerator.php";
generateCustomColorCSS("#FFF"                    // Main color
                     , "#DCAEEE"                 // Theme color
                     , array(                    // Accent colors
                       	  new Theme("#3C4D85", "white")
                       	, new Theme("#F0599C", "white")
                       	, new Theme("#7744A1", "white")
                       	, new Theme("#3C4D85", "white")
                       	, new Theme("#3C4D85", "white")
                       )
                     , 'url("/_img/TS 512.png")' // Branding
					 , "#FDC7F9"
                       );
?>
