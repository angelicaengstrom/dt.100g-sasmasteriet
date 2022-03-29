"use strict";
/*
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
*/
let url = "/~anen1805/DT100G/project/API.php";

document.addEventListener("DOMContentLoaded", function(){
    /* Lyssnar efter knapptryck på ett unikt inlägg */
    document.getElementById("newsfield").addEventListener("click", function(ev){ 
        /* Lyssnar efter knapptryck på 'Ta bort inlägg'-knappen */
        if(ev.target.name == "deletePost"){
            fetch(url + "?post_id=" + ev.target.id, {method: 'DELETE'})
            .then(response => response.json())
            .then(data => {
                location.reload(); // Laddar om sidan efter önskad förfrågan
            })
            .catch(error => {
            alert('There was an error '+error);
            });
        }/* Lyssnar efter knapptryck på 'Redigera inlägg'-knappen */
        else if(ev.target.name == "editPost"){
            let title = document.getElementById("title=" + ev.target.id).value;
            let textArea = document.getElementById("textArea=" + ev.target.id).value;
            let link = document.getElementById("link=" + ev.target.id).value;

            /* Om rubrik- och textinmatningen är tomma skickas ett fel */
            if(title == '' || textArea == ''){ 
                alert("Du måste ha en rubrik och ett inlägg!")
                location.reload(); 
                return;
            }
            let json = {"title": title, "message": textArea, "link": link};
            
            const requestOptions = {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(json)
            }

            fetch(url + "?post_id=" + ev.target.id, requestOptions)
            .then(response => response.json())
            .then(data => {
                location.reload(); // Laddar om sidan efter önskad förfrågan
            })
            .catch(error => {
            alert('There was an error '+error);
            });
        }
    })

    /* Lyssnar efter knapptryck på 'Publicera inlägg'-knappen */
    document.getElementById("createPostbtn").addEventListener("click", function(){
        let title = document.getElementById("textInput").value;
        let imageUpload = document.getElementById("imageupload");
        let textArea = document.getElementById("messageInput").value;
        let link = document.getElementById("linkInput").value;
        
        /* Om rubrik- och textinmatningen är tomma skickas felet till inmatningsrutan */
        if(title == '' || textArea == ''){
            if(title == ''){
                document.getElementById('textErr').innerHTML = '* Titel krävs';
            }
            if(textArea == ''){
                document.getElementById('messageErr').innerHTML = '* Text krävs';
            }
            return;
        }

        const formData = new FormData();

        formData.append('title', title);
        formData.append('message', textArea);
        formData.append('link', link);

        /* Om bild laddas upp bifogas filnamnet och filen i base64 kodning */
        if(imageUpload.files && imageUpload.files[0]){
            var reader = new FileReader();
            reader.readAsDataURL(imageUpload.files[0]);
            reader.onload = function(){
                formData.append('filename', imageUpload.files[0].name)
                formData.append('file', reader.result);
                uploadPost(formData, url);
            }
            reader.onerror = function(error){
                alert(error);
                return;
            };
        }
        else{
            uploadPost(formData, url);
        }
    })
});

/* Skickar en request till url:en med metoden POST för att lägga upp inlägget i databasen*/
function uploadPost(formData, url){
    var object = {};
    formData.forEach((value, key) => object[key] = value);
    var json = JSON.stringify(object);

    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: json
    }
    fetch(url, requestOptions)
        .then(response => response.json())
        .then(data => {
            location.reload(); // Laddar om sidan efter önskad förfrågan
        })
        .catch(error => {
        alert('There was an error '+error);
        });
}

/* Funktion som gör att användaren kan skapa nya inlägg genom att visa inmatningsrutan */
function newPost(){
    document.getElementById("createPostDiv").style.display = "inline-block";
    document.getElementById("newPostFieldsDiv").style.display = "none";
}

/* Funktion som gör att användaren kan ta bort inmatningsrutan för nya inlägg */
function cancelPost(){
    document.getElementById("createPostDiv").style.display = "none";
    document.getElementById("newPostFieldsDiv").style.display = "block";
}

/* Funktion som gör att användaren kan visa/avbryta menyinnehåll */
function displayMenu(){
    document.getElementById("menuContent").classList.toggle("show");
}

/* Hämtar nyhetsflödet för en inloggad användare */
function fetchAdminPost(){
    let f = fetch(url).then(response => response.text())
        .then(data => {
            let jsonData = JSON.parse( data );
            document.getElementById("newsfield").innerHTML = "";
            for(var i = 0; i < jsonData.length; i++){
                let id = jsonData[i].postid;
                
                //Skapar en raderingsknapp till inlägget
                let deletebtn = document.createElement("button");
                deletebtn.innerHTML = "<i class='fa fa-trash'></i>";
                deletebtn.title = "Ta bort inlägget '" + jsonData[i].title + "'";
                deletebtn.id = id;
                deletebtn.name = "deletePost";
                document.getElementById("newsfield").appendChild(deletebtn);
                
                //Skapar ett <article> element till inlägget
                let newsarticle = document.createElement("article");
                newsarticle.id = "article=" + id;
                document.getElementById("newsfield").appendChild(newsarticle);
                
                //Skapar ett <img> element till bilden
                let img = document.createElement("img");
                img.id = "img=" + id;
                let src = "../../writeable/post/" + jsonData[i].image;
                //Om bilden har ett namn adderas bilden från filsystemet
                if(src != "../../writeable/post/"){ 
                    img.alt = "Bild till " + jsonData[i].title;
                    img.src = src;
                }
                else{ //Om bilden inte har ett namn adderas en förbestämd 'null'-bild
                    img.alt = "Tom bild till " + jsonData[i].title;
                    img.src = "images/null.png";
                }
                document.getElementById("article=" + id).appendChild(img);

                //Inläggstexten läggs i en <div> för att kunna placeras i flex-box bredvid <img>
                let div = document.createElement("div");
                div.id = "div=" + id;
                document.getElementById("article=" + id).appendChild(div);

                //Skapar en <label> till inmatningsfältet för rubriken
                let h2 = document.createElement("h2");
                h2.innerHTML = "<label for='title=" + id + "'>Rubrik:</label>";
                document.getElementById("div=" + id).appendChild(h2);

                //Skapar en <input> till inmatningsfält för rubriken
                let titleInput = document.createElement("input");
                titleInput.id = "title=" + id;
                titleInput.type = "text";
                titleInput.name = "title";
                titleInput.value = decodeURIComponent(escape(jsonData[i].title));
                document.getElementById("div=" + id).appendChild(titleInput);

                //Skapar en <label> till inmatningsfältet för inläggstexten
                let h3 = document.createElement("h3");
                h3.innerHTML = "<label for='textArea=" + id + "'>Inlägg:</label>";
                document.getElementById("div=" + id).appendChild(h3);

                //Skapar en <textarea> till inmatningsfältet för inläggstexten
                let textArea = document.createElement("textarea");
                textArea.id = "textArea=" + id;
                textArea.value = decodeURIComponent(escape(jsonData[i].message));
                textArea.rows = 5;
                textArea.name = "message";
                document.getElementById("div=" + id).appendChild(textArea);

                //Skapar en <label> till inmatningsfältet för länken
                h3 = document.createElement("h3");
                h3.innerHTML = "<label for='link=" + id + "'>Länk:</label>";
                document.getElementById("div=" + id).appendChild(h3);

                //Skapar en <input> till inmatningsfältet för länken
                let linkInput = document.createElement("input");
                linkInput.id = "link=" + id;
                linkInput.type = "text";
                linkInput.name = "link";
                linkInput.value = jsonData[i].link;
                document.getElementById("div=" + id).appendChild(linkInput);
                
                //Skapar en redigeringsknapp till inlägget
                let editbtn = document.createElement("button");
                editbtn.innerHTML = "Spara ändringar";
                editbtn.id = id;
                editbtn.name = "editPost";
                editbtn.title = "Spara ändringar";
                document.getElementById("newsfield").appendChild(editbtn);

                //Skapar en radbrytare till inlägget
                let hr = document.createElement("hr");
                hr.style.marginTop = "3%";
                hr.style.marginBottom = "3%";
                document.getElementById("newsfield").appendChild(hr);
            }
        }).catch((error) =>{
            let h4 = document.createElement("h4");
            h4.innerHTML = "Här var det tomt... :(";
            document.getElementById("newsfield").appendChild(h4);
    })
}

/* Hämtar nyhetsflöde för en utloggad användare */
function fetchPost(){
    let f = fetch(url).then(response => response.text())
        .then(data => {
            let jsonData = JSON.parse( data );
            for(var i = 0; i < jsonData.length; i++){
                let id = jsonData[i].postid;

                //Skapar elementet <article> för inlägget
                let newsarticle = document.createElement("article");
                newsarticle.id = "news=" + id;
                document.getElementById("newsfield").appendChild(newsarticle);

                //Om bild finns skapas ett <img> element
                if(jsonData[i].image){
                    let img = document.createElement("img");
                    img.src = "../../writeable/post/" + jsonData[i].image;
                    img.alt = "Bild till " + jsonData[i].title;
                    document.getElementById("news=" + id).appendChild(img);
                }

                //Inläggstexten läggs i en <div> för att kunna placeras i flex-box bredvid <img>
                let div = document.createElement("div");
                div.id = id;
                document.getElementById("news=" + id).appendChild(div);

                //Skapar ett <h2> element för rubriken
                let h2 = document.createElement("h2");
                h2.innerHTML = decodeURIComponent(escape(jsonData[i].title));
                document.getElementById(id).appendChild(h2);

                //Skapar ett <pre> element för inläggstexten
                let pre = document.createElement("pre");
                pre.innerHTML = decodeURIComponent(escape(jsonData[i].message));
                document.getElementById(id).appendChild(pre);

                //Om länk finns skapas ett <a> element
                if(jsonData[i].link){
                    let a = document.createElement("a");
                    a.role = "link";
                    a.href = jsonData[i].link;
                    a.target = "_blank";
                    a.innerHTML = "<i>" + jsonData[i].link + "</i>";
                    document.getElementById(id).appendChild(a);
                }

                //Skapar ett <p> element för datum till inlägget
                let p = document.createElement("p");
                p.innerHTML = "<br><i>Skapat " + jsonData[i].date + "</i>";
                document.getElementById(id).appendChild(p);

                //Skapar en radavbrytare till varje inlägg
                let hr = document.createElement("hr");
                hr.style.marginTop = "3%";
                hr.style.marginBottom = "3%";
                document.getElementById("newsfield").appendChild(hr);
            }
        }).catch((error) =>{
            let h4 = document.createElement("h4");
            h4.innerHTML = "Här var det tomt... :(";
            document.getElementById("newsfield").appendChild(h4);
    })
}
