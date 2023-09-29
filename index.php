<?php

/*
	The player input will go this way : 

	The input will be provided as map
	The map needs to be unpair 
	First they can be more then one rover so I need a mechanism to see how many there is
	Also, I should have a class map that would instintiate my rovers at the given position and make them move when its time

	**MAP PART**
	First line = coordinates of the top right of the map, assume bottom left is 5 X 5

	**ROVER PART**
	Second and third line represent the first rover
*/

include './Map.php';


try{
	$project = new map($argv, $argc);
}
catch (Exception $e){
	echo $e;
}

?>