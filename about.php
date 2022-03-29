<!--
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
-->
<?php 
session_start();
$title = "Om oss";
$css = "about";

include("includes/header.php");

$about = [];

/* Sätter ny information i text-filen om användaren har tryckt på 'SPARA INFORMATION' */
if(isset($_POST['aboutEditBtn'])){
    $about['text'] = $_POST['aboutEdit'];
    $about['email'] = $_SESSION['email'];
    file_put_contents("../../writeable/about.txt", serialize($about));
}

/* Hämtar information från text-filen */
if(file_exists("../../writeable/about.txt")){ //Om filen existeras hämtas alla inlägg till medlemsarrayen
    $about = unserialize(file_get_contents("../../writeable/about.txt"));
}

/* Om användaren är inloggad visas informationen i redigeringsformat */
if(isset($_SESSION['admin'])){
?>
<section class="content">
    <form action="about.php" method="post">
        <h2><label for="aboutEdit">Redigera 'OM OSS':</label></h2>
        <textarea id="aboutEdit" name="aboutEdit" rows="10"><?= $about['text'] ?></textarea>
        <button id="aboutEditBtn" name="aboutEditBtn" title="Publicera information">SPARA INFORMATION</button>
    </form>
</section>
<?php
}else{?>
<!-- Är användaren utloggad visas informationen i standardformat -->
<section id="section1" class="content">
    <h2>OM OSS</h2>
    <pre>
        <?= $about['text'] ?>
    </pre>
    <a href="mailto:<?= $about['email'] ?>"><i class="fa">&#xf0e0;</i><?= $about['email'] ?></a>
</section>
<?php
}

include("includes/footer.php");
?>