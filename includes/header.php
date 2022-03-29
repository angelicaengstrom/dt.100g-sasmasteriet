<!--
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
-->
<!DOCTYPE html> <!--Deklarerar att hemsidan erhåller HTML5-->
<html lang="sv"> <!--Deklarerar att hemsidan innehåll är på svenska-->
<head>
    <!-- Hemsidans titel -->
    <title><?= $title ?></title>

    <!-- Specifierar teckenkodningen -->
    <meta charset="utf-8">
    <!-- Specifierar visningsområdet -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Länk till hemsidans css-filer -->
    <link rel="stylesheet" type="text/css" href="css/styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="css/<?= $css ?>.css?v=<?php echo time(); ?>">

    <!-- Länk till hemsidans typsnitt via googles API -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Josefin+Sans&family=Raleway:wght@400&display=swap" rel="stylesheet">
    
    <!-- Länkning till hemsidans ikoner -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<!--Erhåller hemsidans introduktionsinnehåll-->
<header id="header">
<!--[if IE lt 11]>
    <div class="header">
<![endif]-->

    <!--Såsmästeriets logga och text-->
    <div class="banner">
        
        <img class="logo" role="link" src="images/sas_logo.png" alt="Såsmästeriets logga" title="SÅS" onclick="window.open('index.php', '_self')">
        <h1 class="bannername">Sundsvalls åverålsällskap</h1>
    </div>

    <!--Menyknapp-->
    <div id="menu" class="menuBtn" title="meny" onclick="displayMenu()">
        <p>meny</p> <i class="material-icons">&#xe5d2;</i>
    </div>

<!--[if IE lt 11]>
    </div>
<![endif]-->
</header>

<!--[if IE lt 11]>
    <div class="menuContent">
<![endif]-->

<!-- Erhåller hemsidans navigationslänkar -->
<nav id="menuContent" class="menuContent">
    <ul>
    <li><a class="menuLink" href="index.php"><i class="fa">&#xf015;</i> Senaste nytt</a></li>
    <li><a class="menuLink" href="badges.php"><img class="menuicon" src="images/ovve_icon.png" alt="Ikon på åverall"> Prestationsmärken</a></li>
    <li><a class="menuLink" href="about.php"><i class="fa">&#xf05a;</i> Om oss</a></li>
    <li><a class="menuLink" href='https://www.instagram.com/sasmasteriet/' target='_blank'><i class="fa fa-instagram"></i> Instagram</a></li>
    <li><a class="menuLink" href="https://www.facebook.com/search/top?q=sundsvalls%20%C3%A5ver%C3%A5lss%C3%A4llskap" target='_blank' title="facebook.com/SundsvallsAveralsallskap"><i class="fa fa-facebook-official"></i> Facebook</a></li>
    <li><a class="menuLink" href="https://docs.google.com/forms/d/1J-9S5F_pN3pEihAqObxOtoN2_io13xqNbPGZTuak9HU/viewform?fbclid=IwAR1frw_5rN7Xu-VMt3EJ4yZM0W9HZ6M4e3-BjZY4aclEN_-BBvoVQf3AvIc&edit_requested=true" title="Bli medlem!" target="_blank">
        <i class="fa">&#xf234;</i> Bli medlem!</a></li>
    </ul>
</nav>
<!--[if IE lt 11]>
    </div>
<![endif]-->