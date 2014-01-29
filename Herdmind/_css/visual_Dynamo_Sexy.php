<?PHP
include "dynamoThemeGenerator.php";
generateCustomColorCSS(new Theme("#001945", "#FFF;text-shadow:0 0 0.25em rgba(255,255,255, 0.25)"), // Main color
                       new Theme("#3A4750", "#FFF", "#7BF", "#B7F"),                                // Theme color
                       "#003D67",                                                                   // Accent color
                       'url("/_img/HM 512.png")',                                                   // Branding
                       'rgba(255,255,255, 0.75)'                                                    // Aura
                       );
?>
