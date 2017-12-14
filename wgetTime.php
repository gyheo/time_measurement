<?php
	// Input your test file as a array
	$pages = ["e.g) index.html"];

	// Loop counts
	$loop = 30;

	// File name
	if(strlen($argv[1]) == 0){
		echo 'There is no file name! '.PHP_EOL;
		exit;
	}

	$result = '';
	$statement = '';
	$eachSec = [];

	foreach($pages as $page){
		// Allocate the array
		for($i=0; $i < $loop; $i++){
			if(!isset($eachSec[$page])) {
				$eachSec[$page] = [];
			}

			// 2>&1 is for redirecting
			$command = "wget http://your IP address/{$page} 2>&1";

			$statement = shell_exec($command);
			$result .= $statement;

			// test code
			// echo $statement;

			// Extract the total seconds from the wget
			preg_match_all('/=(.*)/', $statement, $match);

			// Remove s marking
			$sec = trim(str_replace('s', '', $match[1][0]));
			$sec = (double) $sec;
			echo sprintf("%s \n", $sec);
			$eachSec[$page][] = $sec;

			file_put_contents($argv[1], $result);
		}
	}
	$avg = 0;
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
