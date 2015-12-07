<?php
	
	$g = 3;
	$inc = 5;
	for($i=1;$i<31;$i++){
		echo '<p>term '.$i.' = '.$g.'</p>';
		$g = $g+$inc;
		$inc = $inc + 2;
	}