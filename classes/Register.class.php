<!--
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
-->
<?php

class Register {
    private $badges = [];
    private $link = "";

    public function __construct(){
        $this->link = mysqli_connect("studentmysql.miun.se", "anen1805", "6fbxphuk", "anen1805");
        if(!$this->link){ 
            die('Could not connect'); 
        }

        //Hämtar allt innehåll från databasen
        $sql = "select * from badge ORDER BY badge_id DESC;";
        $result = $this->link->query($sql);
        
        if(mysqli_num_rows($result) > 0){
            while($badge = mysqli_fetch_array($result)){ //Lägger in alla inlägg i medlemsarrayen
                $this->badges[] = new Badge($badge["name"], $badge["description"], $badge['img']);
            }
        }
    }

    public function addBadge(string $name, string $description, string $img){
        $this->posts[] = new Badge($name, $description, $img);
        
        //Lägger in de nya värdena i databasen
        $sql = "INSERT into badge(name, description, img) values ('" . $name . "', '" . $description . "', '" . $img . "');";
        $this->link->query($sql);
    }

    public function editBadge(int $index, string $name, string $description){
        //Lägger in de redigerade värdena i databasen
        $sql = "UPDATE badge SET name='" . $name . "', description='" . $description . "' WHERE name='". $this->badges[$index]->getName() . "' AND description='" . $this->badges[$index]->getDescription() . "';";
        $this->link->query($sql);

        $this->badges[$index]->setName($name);
        $this->badges[$index]->setDescription($description);
    }

    public function delBadge(int $index){
        //Tar bort värdena som är ekvivalent vid medlemsarrayens index
        $sql = "DELETE from badge where name='" . $this->badges[$index]->getName() . "' and description='" . $this->badges[$index]->getDescription() . "' and img='" . $this->badges[$index]->getImg() . "';";
        $this->link->query($sql);
        
        unset($this->badges[$index]);
    }

    public function getBadges(){
        return $this->badges;
    }

    public function getBadge($index){
        return $this->badges[$index];
    }
}
?>