<!--
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
-->
<?php
session_start();
if(session_destroy()){
    header('location:../index.php');
}
?>