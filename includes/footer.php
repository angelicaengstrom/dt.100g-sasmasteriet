<!--
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
-->

<!--[if IE lt 11]>
<div class="footer">
<![endif]-->
<footer>

<!--[if IE lt 11]>
<div class="nav">
<![endif]-->
    <nav>
        <!-- google översätt -->
    <div id="google_translate_element" role="button"></div>

<?php
        /* Är användaren utloggad finns länkar till instagram/facebook och inloggning */
        if(!isset($_SESSION['admin'])){ ?>
            <p class="socialMedia"  role='link' onclick="window.open('https://www.facebook.com/search/top?q=sundsvalls%20%C3%A5ver%C3%A5lss%C3%A4llskap', '_blank')" title="facebook.com/SundsvallsAveralsallskap"><i class="fa fa-facebook-official"></i> <b>SundsvallsAveralsallskap</b></p>
            <p class="socialMedia"  role='link' onclick="window.open('https://www.instagram.com/sasmasteriet/', '_blank')" title="instagram.com/sasmasteriet"><i class="fa fa-instagram"></i> <b>@sasmasteriet</b></p>
            <a href='login.php' title='administrativ'>Administrativ inloggning</a>
            <?php
        }
        else{
            /* Är användaren inloggad finns länkar till kontoöversikt och utloggning */
            if($title == "Konto"){
                if(isset($_GET['editInfo']) || isset($_GET['changePass'])){
                    echo "<a href='account.php' title='Till kontoöversikt'>Kontoöversikt</a>";
                }
            }
            else{
                echo "<a href='account.php' title='kontoöversikt'>Kontoöversikt</a>";
            }
            echo "<a href='includes/logout.php' title='logga ut'>Logga ut</a>";
        }
?>
    <p>Sundsvalls Åverålsällskap © anno 2008</p>
    </nav>
<!--[if IE lt 11]>
    </div>
<![endif]-->

</footer>
<!--[if IE lt 11]
</div>
<![endif]-->

<script>
/*Skript för Google Översätt*/
function googleTranslateElementInit() {
new google.translate.TranslateElement({pageLanguage: 'sv', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL}, 'google_translate_element');
}
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!--Skript från main.js-->
<script src="js/main.js?v=<?php echo time(); ?>"></script>

</body>
</html>