<?php 
/*
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
*/
session_start();

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'),true);

header("Content-Type: application/json,charset=UTF-8");

$link = mysqli_connect("studentmysql.miun.se", "anen1805", "6fbxphuk", "anen1805");

/* Om data har skickats i en HTTP förfrågning */
if(isset($input)){
    $title = $input['title'];
    $message = $input['message'];
    $website = $input['link'];
    if(isset($input['file'])){
        $filename = $input['filename'];
        $file = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $input['file']));
    }
}

switch($method){
    case "DELETE":
        /* Tar bort ett inlägg i databasen och den uppladdade filen */
        $sql = "SELECT * FROM post WHERE postid='" . $_GET['post_id'] . "';";
        $result = $link->query($sql);
        $image = $result->fetch_assoc()['image'];

        $sql = "SELECT * FROM post WHERE image='" . $image . "'";
        $result = $link->query($sql);

        /* Om inlägget har en bild och inget annat inlägg använder den bilden tas den bort från filsystemet */
        if($result->num_rows == 1 && !empty($image)){
            $file_pointer = "../../writeable/post/" . $image;
            if (!unlink($file_pointer)) {
                exit();
            }
        }
        $sql = "DELETE FROM post WHERE postid='" . $_GET['post_id'] . "';";
        $link->query($sql) or die;
        break;
    case "PUT":
        /* Redigerar ett inlägg i databasen */
        $sql = "UPDATE post SET titel='" . $title . "', message='" . $message . "', link='" . $website . "' WHERE postid=" . $_GET['post_id'] . ";";
        $link->query($sql) or die;
        break;
    case "POST":
        /* Skapar nytt inlägg i databasen */
        if(isset($filename)){
            file_put_contents("../../writeable/post/" . $filename, $file);
        }else{ $filename = ""; }
        $date = date('j/n Y');
        $sql = "INSERT INTO post(titel, image, message, link, date) VALUES('" . $title . "', '" . $filename . "', '" . $message . "', '" . $website . "', '" . $date . "');";
        $link->query($sql) or die;
        break;
    case "GET":
        /* Hämtar ett specifikt inlägg från databasen */
        if(isset($_GET['post_id'])){
            $sql = "SELECT * FROM post WHERE postid=" . $_GET['post_id'] . ";";
        }else{
            $sql = "SELECT * FROM post ORDER BY postid DESC";
        }
        $link->query($sql) or die;
        break;
}

if($method != "GET"){
    /* Hämtar alla inlägg från databasen */
    $sql = "SELECT * FROM post ORDER BY postid DESC";
}

$result = $link->query($sql) or die;
$post = [];

while($Outputdata = $result->fetch_assoc()){
    $data['postid'] = $Outputdata['postid'];
    $data['title'] = utf8_encode($Outputdata['titel']);
    $data['image'] = $Outputdata['image'];
    $data['message'] = utf8_encode($Outputdata['message']);
    $data['link'] = $Outputdata['link'];
    $data['date'] = $Outputdata['date'];
    array_push($post, $data);
}

mysqli_close($link);
echo json_encode($post); exit;
?>