<!--
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
-->
<?php
    session_start();
    
    /* Om användaren är utloggad omdirigeras sidan*/
    if(!isset($_SESSION['admin'])){
        header('location:index.php');
    }

    $css = 'account';
    $title = 'Konto';
    include("includes/header.php"); 
    include("includes/account.php");

    echo "<section class='content'>";

    /* Om användaren tryckt på att ändra information */
    if(isset($_GET['editInfo'])){ ?>
    <!-- Inmatningsfält för att ändra information -->
    <form action="account.php?editInfo=" method="post">
        <h3><label for="editUsername">Användarnamn:</label></h3>
        <input type="text" id="editUsername" name="adminTxt" value="<?=$_SESSION['admin']?>"><br><br>
        <button name="editNamebtn">Ändra namn</button><br>
        <h3><label for="editEmail">Email:</label></h3>
        <input type="text" id="editEmail" name="emailTxt" value="<?=$_SESSION['email']?>"><br><br>
        <button name="editEmailbtn">Ändra email</button>
    </form>

<?php
    }
    /* Om användaren tryckt på att byta lösenord! */
    else if(isset($_GET['changePass'])){ ?>

    <!-- Inmatningsfält för att ändra lösenord -->
    <form action="account.php" method="post">
        <h3><label for="editPass">Nytt lösenord:</label></h3>
        <input type="password" id="editPass" name="passTxt" placeholder="(minst 5 karaktärer)"><br><br>
        <button name="editPassbtn">Ändra lösenord</button>
    </form>

<?php
    }
    else{ /* Om användaren inte tryckt på någon av knapparna */
?>
    <h2>Namn:</h2>
    <h3><?= $_SESSION['admin'] ?></h3>
    <h2>Email:</h2>
    <h3><?= $_SESSION['email'] ?></h3>
    <!--För att ändra information-->
    <form action="account.php" method="get">
        <button name="editInfo" role="link" title="redigera information">Redigera information</button>
    </form>
    <br>
    <!--För att ändra lösenord-->
    <form action="account.php" method="get">
        <button name="changePass" role="link" title="byt lösenord">Byt lösenord</button>
    </form>

<?php
    }
    echo "</section>";
    include("includes/footer.php");
?>