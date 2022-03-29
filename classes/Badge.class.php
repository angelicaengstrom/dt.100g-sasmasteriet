<!--
Angelica Engström, anen1805, TDTEA
DT058G, Webbprogrammering
Hemsida till SÅS, Sundsvalls åverålsällskap
-->
<?php
/* Alla märken har ett namn, beskrivning och bild */
class Badge { 
	private $name;
	private $description;
    private $img;

	public function __construct(string $n, string $d, string $i){
		$this->name = $n;
		$this->description = $d;
        $this->img = $i;
	}
	function setName(string $n){
		$this->name = $n;
	}
	function getName() : string {
		return $this->name;
	}
	function setDescription(string $d){
		$this->description = $d;
	}
	function getDescription() : string {
		return $this->description;
	}
    function setImg(string $i){
		$this->img = $i;
	}
	function getImg() : string {
		return $this->img;
	}
}

?>