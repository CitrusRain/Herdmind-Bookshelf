<?PHP
include "dynamoThemeGenerator.php";
generateCustomColorCSS(new Theme("#EEE", "#222"),                    // Main colors
                       new Theme("#756242", "#EEE", "#7BF", "#F7B"), // Theme colors
                       new Theme("#3D161E", "#EEE"),                 // Accent colors
                       'url("/_img/Fez 512.svg")'                    // Branding
                       );
?>
