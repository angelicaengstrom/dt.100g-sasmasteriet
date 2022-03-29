<!--
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
-->
<?php 
session_start();
$title = "Prestationsmärken";
$css = "badges";

/* Hämtar klasser för att hämta databasinnehåll */
require_once("classes/Badge.class.php");
require_once("classes/Register.class.php");

$register = new Register();

include("includes/header.php");

echo "<section class='content'>";

/* Om användaren är inloggad visas inmatningsfält för nya märken */
if(isset($_SESSION['admin'])){
    ?>
<h2 class="newBadge">NYTT MÄRKE</h2>

<form class="createBadge" action="badges.php" method="post" enctype="multipart/form-data">
    <pre><label for="badgeName">Namn på märket:</label>
    <input type="text" id="badgeName" name="badgeName" placeholder="Märkesnamn...">

    <label for="badgeFile">Välj bild:</label>
    <input type="file" id="badgeFile" name="badgeFile" accept="image/png, image/gif, image/jpeg">

    <label for="badgeDescription">Beskrivning:</label>
    <textarea id="badgeDescription" name="badgeDescription" rows="10" cols="30" placeholder="Beskrivning av märket..."></textarea></pre>

    <input id="addBadge" name="addBadge" type="submit" value="PUBLICERA MÄRKE" title="publicera märke">
</form>

<hr>

<?php
    /* Om användaren tryckt på att publicera nytt märke*/
    if(isset($_POST['addBadge'])){
        $img_path = "../../writeable/badges/" . $_FILES['badgeFile']['name'];
        if(!file_exists($img_path)){
            /* Om bilden är för stor */
            if($_FILES['badgeFile']['size'] > 500000){
                echo "<script>alert('Bilden är för stor!')</script>";
                exit();
            }
            if(!move_uploaded_file($_FILES['badgeFile']['tmp_name'], $img_path)){
                echo "<script>alert('Misslyckades att ladda upp fil')</script>";
                exit();
            }
        }
         /* Om namn eller beskrivning är tomt */
        if(empty($_POST['badgeName']) || empty($_POST['badgeDescription'])){
                echo "<script>alert('Märkesnamn/beskrivning får inte vara tomt!')</script>";
        }else{
            $register->addBadge($_POST['badgeName'], $_POST['badgeDescription'], $_FILES['badgeFile']['name']);
            header('location:badges.php');
        }
    }

    //Om användaren skickat en förfrågan att ta bort märket
    if(isset($_REQUEST["delBadge"])){
        //Tar bort märken beroende på valt index från hemsidan från databasen
        if($register->getBadge(intval($_REQUEST["delBadge"]))->getImg() != ""){
            $file_pointer = "../../writeable/badges/" . $register->getBadge(intval($_REQUEST["delBadge"]))->getImg();
            if (!unlink($file_pointer)) {
                echo "<script>alert('Misslyckat borttagningsförsök!')</script>";
                exit();
            }
        }
        $register->delBadge(intval($_REQUEST["delPost"]));
        unset($_REQUEST["delPost"]);
        header("Location: badges.php");
    }

    //Om användaren skickat en förfrågan att redigera märket
    if(isset($_POST["editBadge"])){
        //Tar bort märken beroende på valt index från hemsidan i arrayen
        $register->editBadge($_POST['badgeID'], $_POST['editBadgeName'], $_POST['editBadgeDescription']);
        unset($_POST["editBadge"]);
        header('location:badges.php');
    }
}
    echo "<h1>PRESTATIONSMÄRKEN</h1>";
        foreach($register->getBadges() as $key => $obj){
            /* Om användaren är inloggad läggs märkena ut i redigeringsformat */
            if(isset($_SESSION['admin'])){ ?>
                        <!--Vid knapptryck på 'ta bort' omdirigeras användaren till badges.php med en GET metod -->
                        <button title="ta bort <?= $obj->getName()?>" onclick="window.location.href='<?= basename($_SERVER["PHP_SELF"]); ?>?delBadge=<?= $key ?>';">TA BORT <i class="fa fa-trash"></i></button>
                        <form class="editBadge" action="badges.php" method="post">

                            <?php if(!empty($obj->getImg())) { ?>
                            <img class="img" src="../../writeable/badges/<?= $obj->getImg() ?>" alt="Bild på <?= $obj->getName() ?>" title="<?= $obj->getName() ?>">
                            <?php } ?>
                            <div>
                            <h3><label for="editBadgeName">Märke:</label></h3>
                            <input type="text" id="editBadgeName" name="editBadgeName" value="<?= $obj->getName() ?>">
                            
                            <h3><label for="editBadgeDescription">Beskrivning:</label></h3>
                            <textarea id="editBadgeDescription" name="editBadgeDescription" rows="10" cols="30"><?= $obj->getDescription() ?></textarea>
                            
                            <!-- Har ett gömt element som erhåller ID:et märket har i arrayen -->
                            <input type="hidden" name="badgeID" value="<?= $key ?>">
                            <input type="submit" id="editBadge" name="editBadge" value="SPARA ÄNDRINGAR" title="spara ändringar">
                            </div>
                        </form>
            <?php 
                }
                else{
                    /* Om användaren är utloggad läggs märkena ut i ett vanligt format*/
                    echo "<article>";
                    if(!empty($obj->getImg())){
            ?>  
                    <img class="img" src="../../writeable/badges/<?= $obj->getImg() ?>" alt="Bild på <?= $obj->getName() ?>" title="<?= $obj->getName() ?>">
                    <?php } ?>
                    <div>
                        <h2><?= $obj->getName() ?></h2>
                        <pre><?= $obj->getDescription() ?></pre>
                    </div>
                </article>
            <?php
            }
        }

echo "</section>";
include("includes/footer.php");
?>