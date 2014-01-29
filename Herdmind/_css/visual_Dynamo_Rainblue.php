<?PHP
include "dynamoThemeGenerator.php";
generateCustomColorCSS("#FFF"                      // Main color
                       , "#9FE7FF"                 // Theme color
                       , array(                    // Accent colors
                         	  "#38ABEE"
                         	, new Theme("#75459B", "white")
                         	, "#FE585A"
                         	, "#FF7D43"
                         	, "#F2E576"
                         	, "#6ECF5B"
                         )
                       , 'url("/_img/RD 512.png")' // Branding
                       );
?>
