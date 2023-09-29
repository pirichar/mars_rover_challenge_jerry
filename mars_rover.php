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

class map {

	private $map_size = array();
	private $map = array();
	private $user_input = array();
	private $nb_of_rovers;
	private $rover_array;


	function __construct($argv, $argc){
		//parse the map and get the data
		try{
			$this->parse_map($argv, $argc);
		}
		catch(Exception $e){
			throw $e;
		}
		//actually create the map and spawn the rovers
		echo "Map Size :" ;
		foreach ($this->map_size as $value){
			echo "[$value]";
		}
		echo "\n";
		echo "Nb of rovers [$this->nb_of_rovers]\n";
		$this->instantiate_rovers();
	}

	function parse_map($argv, $argc){
		//check that the user provided at least an argument to the function
		if ($argc < 2 ){
			echo ("Within parse_map"). "this is argv : \n";
			throw new Exception ("Please provide the map");
		}
		//gather the map and put it into an array
		$map = fopen($argv[1], "r") or die ("Please provide a file to open\n");
		$this->user_input = explode("\n", fread($map, filesize($argv[1])));
		fclose($map);
		$line_count = count($this->user_input);
		if ($line_count  % 2 == 0 ){
			throw new Exception("You did not provided a map with the right format\n");
		}
		//get the nb of rovers and create the variables;
		$this->nb_of_rovers = ($line_count - 1) / 2;
		/*
			Map checking: the map is at $file_array[0]
			we use the function array_map to force explode to return so ints
			This means that we have our map size in our structure data
			Then we just check that we not have a map size of 0 
			This could be a seperated method to make everything more clean
		*/
		$this->map_size = array_map('intval', explode(' ', $this->user_input[0]));
		if ($this->map_size[0] == 0){
			throw new Exception ("Was not able to get the map size");
		}
	}

	function instantiate_rovers(){
		//then instantiate the rovers and move them one by one (instantiate move, instantiate move)
		for($i = $this->nb_of_rovers, $y = 1, $n = 1; $i > 0; $i--){
			$this->rover_array[$y - 1] = new mars_rover($n,$this->user_input[$y], $this->user_input[$y+1]);
			$y = $y+2;
			$n++;
		}
	}



}

class mars_rover{

	private $direction = ["N", "W", "S", "E"];
	private $coordinate = array(0 ,0);
	private $rover_name;
	private $move_set;

	function __construct($name, $position, $direction){
		$this->rover_name = $name;
		$this->move_set = $direction;
		$this->announce_yourself_start();
		$this->set_position($position);
		$this->parse_movement();
		$this->announce_yourself_end();
	}

	private function announce_yourself_start(){
		echo "\nHello from Rover " . $this->rover_name .", i just arrived here " ."\n" ;
		echo "Rover coordinates = ". $this->coordinate[0] . " " .  $this->coordinate[1]. "\n";
		echo "Rover is facing = ". $this->direction[0] . " " . "\n";
		echo "I will have to move = ". $this->move_set. "\n";
	}

	private function announce_yourself_end(){
		echo "\nHello from Rover " . $this->rover_name . " I am now done with my mission ". "\n" ;
		echo "Rover coordinates = ". $this->coordinate[0] . " " .  $this->coordinate[1]. "\n";
		echo "Rover is facing = ". $this->direction[0] . " " . "\n";
	}
	
	private function set_position($position){
		//first split the position into an array of 3 characters
		$splitted_position = explode(' ',$position);
		if(count($splitted_position ) > 3){
			throw new Exception ("Please provide the position of the rover this way 1 2 N \n");
		}
		//get the X and Y coordinates
		$this->coordinate = array_map('intval',array_slice($splitted_position, 0,2));
		//Get the facing direction
		$actual_coordinate = array_slice($splitted_position, 2);
		if (in_array($actual_coordinate[0], $this->direction )){
			$current_index = array_search($actual_coordinate[0], $this->direction);
			$this->direction = array_merge(
				array_slice($this->direction, $current_index),
				array_slice($this->direction, 0, $current_index)
			);
		}
		else{
			throw new Exception("Invalid initial direction");
		}
	}


	
	/*
	Logic to turn: L and R make the rover spin 90 degress left or right respectively
	you start on the 0 position of the array which is north 
	when the user provides you an L you go downward into the array
	when the user provides you an R you go upward into the array
	The position should wrap around the array meaning that if 
	you are at index 0 and you recieve an L you should get to the position 3
	*/
	private function parse_movement(){
		//go through the moveset string and apply the right movement
		foreach (str_split($this->move_set) as $char){
			if ($char == 'L'){
				$this->rotate_left();
			}
			if ($char == 'R'){
				$this->rotate_right();
			}
			if ($char == 'M'){
				$this->move_rover();
			}
		}
		
	}
	/*
		Logic to move around : M najes the rove move forware by 1 grid point 
		If you are N or S ; you affect the [0,Y] coordinate (y)
		If you are W or E; you affect the [X,0] coordinate (x)
	*/

	private function move_rover(){
		if ($this->direction[0] == "N"){
			$this->coordinate[0]++;
		}
		if ($this->direction[0] == "S"){
			$this->coordinate[0]--;
		}
		if ($this->direction[0] == "W"){
			$this->coordinate[0]++;
		}
		if ($this->direction[0] == "E"){
			$this->coordinate[0]--;
		}
	}

   	private function rotate_right() {
        // Rotate right by shifting the array to the left
        $firstDirection = array_shift($this->direction);
        array_push($this->direction, $firstDirection);
    }

    private function rotate_left() {
        // Rotate left by shifting the array to the right
        $lastDirection = array_pop($this->direction);
        array_unshift($this->direction, $lastDirection);
    }



}

try{
	$project = new map($argv, $argc);
}
catch (Exception $e){
	echo $e;
}

?>