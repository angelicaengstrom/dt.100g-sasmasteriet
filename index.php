<!--
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
-->
<?php 
session_start();
$title = "Senaste nytt";
$css = "start";

include("includes/header.php");
include("includes/index.php");
include("includes/footer.php");

/* Om användaren är inloggad */
if(isset($_SESSION['admin'])){
    echo "<script>fetchAdminPost();</script>";
}else{
    echo "<script>fetchPost();</script>";
}
?>