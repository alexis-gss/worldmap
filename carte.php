<?php
    if(isset($_COOKIE["checkLang"])){
        $_POST['lang'] = htmlspecialchars($_COOKIE["checkLang"]);
        unset($_COOKIE["checkLang"]);
        setcookie("checkLang", "", time() - 4200, "/");
    }
    require "decide-lang.php";
?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <link href='https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,700,800' rel='stylesheet' type='text/css'>
        <link rel="icon" href="data/worldmaplogo.png">
        <title>WorldMap - Carte</title>
        
        <!-- lien vers des fichiers pour utiliser la librairie leaflet -->
        <link rel="stylesheet" href="css/leaflet.css"/>
        <script src="lib/Leaflet.js"></script>

        <!-- lien vers les fichiers .js pour rassembler des marqueurs -->
        <link rel="stylesheet" href="lib/MarkerCluster.css" />
        <script src="lib/Markercluster.js"></script>
        
        <!-- lien vers le fichier .js pour faire des graphiques -->
        <script type="text/javascript" src="lib/Chart.min.js"></script>

        <!-- lien vers la police -->
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

        <!-- lien vers le fichier .css -->
        <link rel="stylesheet" href="css/style_carte.css">
    </head>
    <body>
    <section class="loader">
	    <img src="data/worldmaplogo.png" alt="<?php echo LOADER_ALT; ?>"/>
        <h2><?php echo LOADER_CHARGEMENT; ?></h2>
        <div></div>
    </section>
        
        <!-- Carte -->
        <section id="map"></section>

        <!-- Menu général -->
        <section class="content">
            <section class="menu">
                <div class="menuNav">
                    <img class="menuLogoMps" src="data/worldmaplogo.png">
                    <span class="menuSeparation"></span>
                    <btn class="btnExit" title="<?php echo MAP_TITLE_DECONNECTION; ?>">
                        <svg class="btnSVG">
                            <use href="#icon-exit"></use>
                        </svg>
                    </btn>
                    <span class="menuSeparation"></span>
                    <btn title="<?php echo MAP_TITLE_PARAMETRES_OUVRIR; ?>">
                        <svg class="btnSVG btnSVGparametres">
                            <use href="#icon-cog"></use>
                        </svg>
                    </btn>
                    <btn title="<?php echo MAP_TITLE_PARAMETRES_FERMER; ?>">
                        <svg class="btnSVG parametresBtnSVGcross displayNone">
                            <use href="#icon-cross"></use>
                        </svg>
                    </btn>
                </div>
                <div class="menuContent">
                    <div class="menuContentInstallations">
                        <div class="menuContentInstallationsHeader">
                            <h2 class="installationsTitre"></h2>
                        </div>
                        <div id="idTableau" class="installations"></div>
                    </div>
                    <div class="parametres displayNone">
                        <h2 class="installationsTitre"><?php echo MAP_PARAMETRES_TITRE; ?></h2>
                        <form class="login__form__lang" method="post" action="carte.php">
                            <?php
                                include "templates/worldmap_lang.inc.php";
                            ?>
                        </form>
                        <?php
                            include "templates/worldmap_darkmode.inc.php";
                        ?>
                    </div>
                    <btn class="btnFleche" title="<?php echo MAP_TITLE_ROULER_DEROULER; ?>">
                        <svg class="btnSVG btnSVGFleche">
                            <use href="#icon-arrow-up2"></use>
                        </svg>
                    </btn>
                </div>
            </section>
        <section>
        
        <!-- Bouton recentrer -->
        <btn class="btnRecentrer" title="<?php echo MAP_TITLE_RECENTRER; ?>">
            <svg class="btnSVG">
                <use href="#icon-shrink"></use>
            </svg>
        </btn>
        <!-- Bouton pour mettre/sortir en/du plein écran -->
        <btn class="btnPleinEcran" title="<?php echo MAP_TITLE_PLEIN_ECRAN; ?>">
            <svg class="btnSVG btnSVGoff">
                <use href="#icon-enlarge2"></use>
            </svg>
            <svg class="btnSVG btnSVGon displayNone">
                <use href="#icon-shrink2"></use>
            </svg>
        </btn>

        <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
                <symbol id="icon-cog" viewBox="0 0 32 32">
                    <path d="M29.181 19.070c-1.679-2.908-0.669-6.634 2.255-8.328l-3.145-5.447c-0.898 0.527-1.943 0.829-3.058 0.829-3.361 0-6.085-2.742-6.085-6.125h-6.289c0.008 1.044-0.252 2.103-0.811 3.070-1.679 2.908-5.411 3.897-8.339 2.211l-3.144 5.447c0.905 0.515 1.689 1.268 2.246 2.234 1.676 2.903 0.672 6.623-2.241 8.319l3.145 5.447c0.895-0.522 1.935-0.82 3.044-0.82 3.35 0 6.067 2.725 6.084 6.092h6.289c-0.003-1.034 0.259-2.080 0.811-3.038 1.676-2.903 5.399-3.894 8.325-2.219l3.145-5.447c-0.899-0.515-1.678-1.266-2.232-2.226zM16 22.479c-3.578 0-6.479-2.901-6.479-6.479s2.901-6.479 6.479-6.479c3.578 0 6.479 2.901 6.479 6.479s-2.901 6.479-6.479 6.479z"></path>
                </symbol>
            </defs>
        </svg>
        <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
                <symbol id="icon-shrink" viewBox="0 0 32 32">
                    <path d="M18 14h13l-5-5 6-6-3-3-6 6-5-5z"></path>
                    <path d="M18 18v13l5-5 6 6 3-3-6-6 5-5z"></path>
                    <path d="M14 18h-13l5 5-6 6 3 3 6-6 5 5z"></path>
                    <path d="M14 14v-13l-5 5-6-6-3 3 6 6-5 5z"></path>
                </symbol>
            </defs>
        </svg>
        <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
                <symbol id="icon-enlarge2" viewBox="0 0 32 32">
                    <path d="M32 0v13l-5-5-6 6-3-3 6-6-5-5zM14 21l-6 6 5 5h-13v-13l5 5 6-6z"></path>
                </symbol>
            </defs>
        </svg>  
        <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
                <symbol id="icon-shrink2" viewBox="0 0 32 32">
                    <path d="M14 18v13l-5-5-6 6-3-3 6-6-5-5zM32 3l-6 6 5 5h-13v-13l5 5 6-6z"></path>
                </symbol>
            </defs>
        </svg>
        <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
                <symbol id="icon-arrow-down2" viewBox="0 0 32 32">
                    <path d="M27.414 19.414l-10 10c-0.781 0.781-2.047 0.781-2.828 0l-10-10c-0.781-0.781-0.781-2.047 0-2.828s2.047-0.781 2.828 0l6.586 6.586v-19.172c0-1.105 0.895-2 2-2s2 0.895 2 2v19.172l6.586-6.586c0.39-0.39 0.902-0.586 1.414-0.586s1.024 0.195 1.414 0.586c0.781 0.781 0.781 2.047 0 2.828z"></path>
                </symbol>
            </defs>
        </svg>
        <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
                <symbol id="icon-arrow-up2" viewBox="0 0 32 32">
                    <path d="M27.414 12.586l-10-10c-0.781-0.781-2.047-0.781-2.828 0l-10 10c-0.781 0.781-0.781 2.047 0 2.828s2.047 0.781 2.828 0l6.586-6.586v19.172c0 1.105 0.895 2 2 2s2-0.895 2-2v-19.172l6.586 6.586c0.39 0.39 0.902 0.586 1.414 0.586s1.024-0.195 1.414-0.586c0.781-0.781 0.781-2.047 0-2.828z"></path>
                </symbol>
            </defs>
        </svg>
        <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
                <symbol id="icon-exit" viewBox="0 0 32 32">
                    <path d="M24 20v-4h-10v-4h10v-4l6 6zM22 18v8h-10v6l-12-6v-26h22v10h-2v-8h-16l8 4v18h8v-6z"></path>
                </symbol>
            </defs>
        </svg>
        <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
                <symbol id="icon-flickr" viewBox="0 0 32 32">
                    <path d="M0 17c0-3.866 3.134-7 7-7s7 3.134 7 7c0 3.866-3.134 7-7 7s-7-3.134-7-7zM18 17c0-3.866 3.134-7 7-7s7 3.134 7 7c0 3.866-3.134 7-7 7s-7-3.134-7-7z"></path>
                </symbol>
            </defs>
        </svg>
        <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
                <symbol id="icon-cross" viewBox="0 0 32 32">
                    <path d="M31.708 25.708c-0-0-0-0-0-0l-9.708-9.708 9.708-9.708c0-0 0-0 0-0 0.105-0.105 0.18-0.227 0.229-0.357 0.133-0.356 0.057-0.771-0.229-1.057l-4.586-4.586c-0.286-0.286-0.702-0.361-1.057-0.229-0.13 0.048-0.252 0.124-0.357 0.228 0 0-0 0-0 0l-9.708 9.708-9.708-9.708c-0-0-0-0-0-0-0.105-0.104-0.227-0.18-0.357-0.228-0.356-0.133-0.771-0.057-1.057 0.229l-4.586 4.586c-0.286 0.286-0.361 0.702-0.229 1.057 0.049 0.13 0.124 0.252 0.229 0.357 0 0 0 0 0 0l9.708 9.708-9.708 9.708c-0 0-0 0-0 0-0.104 0.105-0.18 0.227-0.229 0.357-0.133 0.355-0.057 0.771 0.229 1.057l4.586 4.586c0.286 0.286 0.702 0.361 1.057 0.229 0.13-0.049 0.252-0.124 0.357-0.229 0-0 0-0 0-0l9.708-9.708 9.708 9.708c0 0 0 0 0 0 0.105 0.105 0.227 0.18 0.357 0.229 0.356 0.133 0.771 0.057 1.057-0.229l4.586-4.586c0.286-0.286 0.362-0.702 0.229-1.057-0.049-0.13-0.124-0.252-0.229-0.357z"></path>
                </symbol>
            </defs>
        </svg>
        <svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <defs>
                <symbol id="icon-download3" viewBox="0 0 32 32">
                    <path d="M23 14l-8 8-8-8h5v-12h6v12zM15 22h-15v8h30v-8h-15zM28 26h-4v-2h4v2z"></path>
                </symbol>
            </defs>
        </svg>

        <?php
            require "js/main_carte.php"
        ?>
    </body>