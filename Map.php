<?php

/*

 */
include './Mars_rover.php';

class Map {
	private $map_size = array();
	private $user_input = array();
	private $nb_of_rovers;
	private $rover_array;


	function __construct($argv, $argc){
		//parse the map and get the data
		try{
			$this->parse_and_initiate($argv, $argc);
		}
		catch(Exception $e){
			throw $e;
		}
		//actually create the map and spawn the rovers

		$this->announce_map();
		$this->instantiate_rovers();
	}
	
	private function announce_map(){

		echo "Hello, welcome user, please change the map file to test what ever you want \n",
		"Current Map Size :" ;
		foreach ($this->map_size as $value){
			echo "[$value]";
		}
		echo "\n";
		echo "Nb of rovers [$this->nb_of_rovers]\n";
	}

	private function parse_and_initiate($argv, $argc){
		//check that the user provided at least an argument to the function
		if ($argc < 2 ){
			throw new Exception ("Please provide the map");
		}
		//gather the map and put it into an array
		$map = fopen($argv[1], "r") or die ("Please provide a file to open\n");
		$this->user_input = explode("\n", fread($map, filesize($argv[1])));
		fclose($map);
		//validate the nb of rover
		$line_count = count($this->user_input);
		if ($line_count  % 2 == 0 ){
			throw new Exception("You did not provided a map with the right format\n");
		}
		//get the nb of rovers and create the variables;
		$this->nb_of_rovers = ($line_count - 1) / 2;
		$this->map_checking();
	}

	private function map_checking(){
			/*
			Map checking: the map is at $file_array[0]
			we use the function array_map to force explode to return so ints
			This means that we have our map size in our structure data
			Then we just check that we not have a map size of 0 
			This could be a seperated method to make everything more clean
			I also check that the array is 2 , if not I don't have a proper set of coordinates
		*/
		$this->map_size = array_map('intval', explode(' ', $this->user_input[0]));
		if ($this->map_size[0] == 0 ||  sizeof($this->map_size) != 2){
			throw new Exception ("Was not able to get the map size");
		}
	}

	private function instantiate_rovers(){
		//then instantiate the rovers and move them one by one (instantiate move, instantiate move)
		for($i = $this->nb_of_rovers, $y = 1, $n = 1; $i > 0; $i--){
			$this->rover_array[$y - 1] = new mars_rover($n,$this->user_input[$y], $this->user_input[$y+1], $this->map_size);
			$y = $y+2;
			$n++;
		}
	}



}


?>