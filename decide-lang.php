<?php
    if(empty($_POST['lang'])){
        $_POST['lang'] = 'fr';
    };
    if ($_POST['lang']=='fr') {           // si la langue est 'fr' (français) on inclut le fichier fr-lang.php
        include('lang/fr-lang.php');
    } 
    else if ($_POST['lang']=='en') {      // si la langue est 'en' (anglais) on inclut le fichier en-lang.php
        include('lang/en-lang.php');
    }
    else if ($_POST['lang']=='sp') {      // si la langue est 'sp' (espagnol) on inclut le fichier sp-lang.php
        include('lang/sp-lang.php');
    }
    else if ($_POST['lang']=='de') {      // si la langue est 'de' (allemand) on inclut le fichier de-lang.php
        include('lang/de-lang.php');
    }
?>