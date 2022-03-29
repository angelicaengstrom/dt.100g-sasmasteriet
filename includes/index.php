<!--
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
-->
<section class="content">
    <div class="contentTitle">
        <!-- Utloggade användare ser rubriken -->
        <h2 id="contentTitle"><?php if(!isset($_SESSION['admin'])){ echo "SENASTE NYTT"; } ?></h2>
    </div>

<?php 
//Inloggade användare ska få upp innehåll för att skapa nya inlägg
    if(isset($_SESSION['admin'])){
        ?>
        <!-- Knapp för att visa inmatningsfälten för nya inlägg -->
        <div id="newPostFieldsDiv">
            <button id="newPostbtn" class="newPostBtn" name="newPost" title="skapa inlägg" onclick="newPost()">SKAPA INLÄGG  <i class='material-icons'>&#xe22b;</i></button>
        </div>

        <div id="createPostDiv" class="createPost">
            <!-- Knapp för att ta bort inmatningsfälten för nya inlägg -->
            <button id="cancelbtn" class="cancelPostBtn" name="cancelPost" title="avbryt" onclick="cancelPost()"><i class="fa fa-close"></i></button>
            
            <!--Inmatningsfälten för att skapa nya inlägg-->
            <h2>NYTT INLÄGG</h2>
            <h3><label for="textInput">Rubrik: </label></h3>
            <input type="text" id="textInput" class="createPostInput" name="textInput" placeholder="ex. Syjunta">
            <p id="textErr"></p>

            <h3><label for="imageupload">Bild:</label></h3>
            <input type="file" id='imageupload' name='imageupload' accept="image/png, image/gif, image/jpeg">

            <h3><label for="linkInput">Länk:</label></h3>
            <input type="text" id="linkInput" class="createPostInput" name="linkInput">

            <h3><label for="messageInput">Inlägg:</label></h3>
            <textarea rows="5" id="messageInput" class="createPostInput" name="messageInput"></textarea>
            <p id="messageErr"></p>

            <!--Knapp för att publicera nya inlägg på hemsidan-->
            <button id="createPostbtn" class="createPostBtn" name="createPost" title="publicera inlägg">PUBLICERA INLÄGG</button>
    </div>
        <?php
    }
?>


<section id="newsfield"></section>
</section>
