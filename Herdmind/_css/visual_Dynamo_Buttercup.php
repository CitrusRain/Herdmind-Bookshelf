<?PHP
include "dynamoThemeGenerator.php";
generateCustomColorCSS("#FFF" // Main color
                     , new Theme("#111", "#DDD")                                 // Theme color
                     , array(
                     	  new Theme("#44B72D", "#222")
                     	, new Theme("#44B72D", "#222")
                     	, new Theme("#000", "#DDD")
                     	, new Theme("#44B72D", "#222")
                     	, new Theme("#44B72D", "#222")
                     	)                          // Accent color
                     , 'url("/_img/Bu 512.png")'                 // Branding
                     , '#44B72D'                                 // Aura
                       );
?>
