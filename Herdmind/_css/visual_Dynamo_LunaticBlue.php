<?PHP
include "dynamoThemeGenerator.php";
generateCustomColorCSS(new Theme("#000", "#DDD", "#7BF", "#B7F") // Main color
                     , new Theme("#2A3C78", "#DDD")              // Theme color
                     , "#1448AD"                                 // Accent color
                     , 'url("/_img/PL 512.png")'                 // Branding
                     , '#325BAF'                                 // Aura
                       );
?>
