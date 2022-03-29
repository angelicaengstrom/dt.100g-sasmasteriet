<!--
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
-->
<?php
    /* Om användaren tryckt på att spara ändringar vid namnändring*/
    if(isset($_POST['editNamebtn'])){
        $name = $_POST['adminTxt'];
        /* Om namnet är i korrekt format och ifyllt uppdateras namnet i databasen */
        if(empty($name)){
            echo "<script>alert('Användarnamn får inte vara tomt!');</script>";
        }
        else if(!preg_match("/^[a-zA-Z-' ]*$/", $name)){
            echo "<script>alert('Endast karaktärerna a-z och A-Z är godkända!');</script>";
        }
        else{
            $link = mysqli_connect("studentmysql.miun.se", "anen1805", "6fbxphuk", "anen1805");
            $sql = "UPDATE users SET name='" . $name . "' WHERE email='" . $_SESSION['email'] . "';";
            $link->query($sql);

            $_SESSION['admin'] = $name;
            mysqli_close($link);
            header('location:account.php');
        }
    } /* Om användaren tryckt på spara ändringar vid emailändring */
    else if(isset($_POST['editEmailbtn'])){
        $email = $_POST['emailTxt'];
        /* Om emailen är i korrekt format och ifyllt uppdateras emailen i databasen */
        if(empty($email)){
            echo "<script>alert('Email får inte vara tomt!');</script>";
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "<script>alert('Ogiltigt email format!');</script>";
        }
        else{
            $link = mysqli_connect("studentmysql.miun.se", "anen1805", "6fbxphuk", "anen1805");
            $sql = "UPDATE users SET email='" . $email . "' WHERE name='" . $_SESSION['admin'] . "';";
            $link->query($sql);

            $_SESSION['email'] = $email;
            mysqli_close($link);
            header('location:account.php');
        }
    } /* Om användaren tryckt på spara ändringar vid lösenordsändring*/
    else if(isset($_POST['editPassbtn'])){
        $password = $_POST['passTxt'];
        /* Om lösenordet är i korrekt format uppdateras lösenordet i ett krypterat format i databasen */
        if(strlen($password) < 5){
            echo "<script>alert('Lösenordet måste vara minst 5 karaktärer!')</script>";
        }
        else{
            $link = mysqli_connect("studentmysql.miun.se", "anen1805", "6fbxphuk", "anen1805");
            $sql = "UPDATE users SET password='" . hash("ripemd160", $password) . "' WHERE name='" . $_SESSION['admin'] . "';";
            $link->query($sql);
            mysqli_close($link);
            echo "<script>alert('Byte av lösenord lyckades!')</script>";
        }
    }
?>