<?PHP
include "dynamoThemeGenerator.php";
generateCustomColorCSS("#FFF" // Main color
                     , "#FCEC62"                                 // Theme color
                     , array(
                     	  "#35ACE6"
                     	, "#35ACE6"
                     	, new Theme("#000", "#DDD")
                     	, "#35ACE6"
                     	, "#35ACE6"
                     	)                          // Accent color
                     , 'url("/_img/Bu 512.png")'                 // Branding
                     , '#35ACE6'                                 // Aura
                       );
?>
