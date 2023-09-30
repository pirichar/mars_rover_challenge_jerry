<?php

/*


*/
class mars_rover{
	private $direction = ["N", "W", "S", "E"];
	private $coordinate = array(0 ,0);
	private $rover_name;
	private $move_set;
	private $map_size;

	function __construct($name, $position, $direction, $map_size){
		$this->rover_name = $name;
		$this->move_set = $direction;
		$this->map_size = $map_size;
		$this->set_position($position);
		$this->announce_yourself_start();
		$this->print_map();
		$this->parse_movement();
		$this->announce_yourself_end();
		$this->print_map();
	}

	private function print_map(){
		echo "\n";
		for($i = $this->map_size[1]; $i >= 0; $i--){
			for($j = 0; $j <= $this->map_size[0]; $j++){
				if ($j == $this->coordinate[0] && $i == $this->coordinate[1]){
					echo "x";
				}
				else
					echo "0";
			}
			echo "\n";
		}
	}
	

	private function announce_yourself_start(){
		echo "\nHello from Rover " . $this->rover_name .", i just arrived here " ."\n" ;
		echo "Rover coordinates = ". $this->coordinate[0] . " " .  $this->coordinate[1]. "\n";
		echo "Rover is facing = ". $this->direction[0] . " " . "\n";
		echo "I will have to move = ". $this->move_set. "\n";
	}

	private function announce_yourself_end(){
		echo "\nHello from Rover " . $this->rover_name . ", I am now done with my mission ". "\n" ;
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
		If you are N or S ; you affect the [0,Y] coordinate (y) (index 1)
		If you are W or E; you affect the [X,0] coordinate (x)(index 0)
	*/

	private function move_rover(){
		if ($this->direction[0] == "W" && $this->coordinate[0] < $this->map_size[0]){
			$this->coordinate[0]++;
		}
		else if ($this->direction[0] == "E" && $this->coordinate[0] < $this->map_size[0]){
			$this->coordinate[0]--;
		}
		else if ($this->direction[0] == "N" && $this->coordinate[1] < $this->map_size[1]){
			$this->coordinate[1]++;
		}
		else if ($this->direction[0] == "S" && $this->coordinate[1] < $this->map_size[1]){
			$this->coordinate[1]--;
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



?>