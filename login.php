<!--
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
-->
<?php
session_start();

$title = "Administrativ";
$css = "login";

/* Om användaren tryckt 'LOGGA IN' */
if(isset($_POST['loginbtn'])){
    $link = mysqli_connect("studentmysql.miun.se", "anen1805", "6fbxphuk", "anen1805");    
    if(mysqli_connect_errno()){
        echo "<script>alert('Failed connection with database');</script>";
    }

    $username = $_POST['userInput'];
    $password = $_POST['passwordInput'];

    $sql = "SELECT * FROM users WHERE name='" . $username . "' AND password='" . hash("ripemd160", $password) . "';";
    
    $result = $link->query($sql);

    /*Om användaren finns i databasen*/
    if($result->num_rows == 1){
        /* Om kom-ihåg-mig-checkboxen var ifylld skapas en cookie som kommer ihåg användaren */
        if(!empty($_POST["loginCheck"])) {
            setcookie ("username",$_POST["userInput"],time()+ 3600);
            setcookie ("password",$_POST["passwordInput"],time()+ 3600);
        } else {
            setcookie("username","", time() - 3600);
            setcookie("password","", time() - 3600);
        }
        $_SESSION['admin'] = $username;
        $_SESSION['email'] = $result->fetch_assoc()['email'];
        header('location:index.php');
    }
    else{
        echo "<script>alert('Fel användarnamn/lösenord'); </script>";
    }
    mysqli_close($link);
}

include("includes/header.php");
?>

<section class="content">
<h2 id="title">LOGGA IN</h2>
<!-- Inmatningsfält för inloggning -->
<form action="login.php" method="post">
    <h3><label for="userInput">Användarnamn:</label></h3>
    <input type="text" class="loginInput" role="textbox" id="userInput" name="userInput" placeholder="Användarnamn" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>">

    <h3><label for="passwordInput">Lösenord:</label></h3>
    <input type="password" class="loginInput" role="textbox" name="passwordInput" placeholder="Lösenord" id="passwordInput" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">

    <p><input type="checkbox" name="loginCheck" id="loginCheck" <?php  if(!empty($_COOKIE["username"])) { echo "checked='true'"; } ?>/>
    <label for="loginCheck">Kom ihåg mig</label></p>
    <input type="submit" class="loginBtn" name="loginbtn" role="link" value="Logga in" title="logga in">
</form>
</section>

<?php 
include("includes/footer.php");
?>