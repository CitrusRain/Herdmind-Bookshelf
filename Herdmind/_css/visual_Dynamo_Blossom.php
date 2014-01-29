<?PHP
include "dynamoThemeGenerator.php";
generateCustomColorCSS("#FFF" // Main color
                     , new Theme("#DB2B39", "#FFF", "#7BF", "#F7B") // Theme color
                     , array(
                     	  "#EC676B"
                     	, "#EC676B"
                     	, new Theme("#000", "#DDD")
                     	, "#EC676B"
                     	, "#EC676B"
                     	)                           // Accent color
                     , 'url("/_img/Bl 512.png")'    // Branding
                     , '#EC676B'                    // Aura
                       );
?>
