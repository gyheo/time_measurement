<?php
	// Input your test file as a array
	$pages = ["e.g) index.html"];

	// Loop count
	$loop = 30;

	// File name check
	if(strlen($argv[1]) == 0){
		echo 'There is no file name! '.PHP_EOL;
		exit;
	}

	$result = '';
	$statement = '';
	$eachSec = [];

	// test code
	// $command = "curl -o /dev/null -s -w %{time_total}\\n https://192.9.81.204/{$pages[0]}";

	foreach($pages as $page){
		// Allocate the array
		for($i=0; $i < $loop; $i++){
			if(!isset($eachSec[$page])) {
				$eachSec[$page] = [];
			}

			// Input the commands for curl
			$command = "curl -o /dev/null -s -w %{time_total}  http://serverIP address/{$page}";

			$sec = shell_exec($command);
			$result .= $sec . ' ';
			echo $sec . ' ';

			// test code
			// echo $statement;

			$eachSec[$page][] = $sec;

			// echo $output[0];
			file_put_contents($argv[1], $result);
		}
		$result .= '\n';
	}
	$avg = 0;

	// For visual
	echo "\n\n";
	foreach($eachSec as $flow) {
		for($i=0; $i < $loop; $i++){
			echo $flow[$i] . " ";
		}

		$sum = array_sum($flow);
		$avg = (double) $sum / count($flow);

		echo "\n AVERAGE is ". $avg . ' ';
		echo "\n";
	}

?>
