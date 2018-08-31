<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="txt">
        <input type="submit" name="submit" id="">
    </form>
</body>
</html>


<?php 


$from = "1-09-1999";
$to = "12-09-1999";

$from = date($from);
$to   = date($to);
$from = strtotime($from);
$to   = strtotime($to);
// function to find the difference / number of days between 2 dates(intimestamps) 
	// then rconverts the difference in seconds to days by deviding it with 86400(24hours in seconds)
function daydiff($from,$to){
	$re  = $to-$from;
	$re  = round($re/86400);
	// echo $re;
	return $re;
}

// makes array of strings to actual date format
function generateDate($day,$month,$year){
	$date = $day."-".$month."-".$year;
	echo "agenratDate()".$date."<br>";
	return $date;
}
function calculateDates($from,$days){
	$genDate_combi = array();
	$init = date("d-m-Y",$from);
	$init = explode("-", $init);
	// echo "in the calc";
	// echo $init[0]."--before";
	// echo $init[1];
	// echo $init[2];
	$i=1;
	while($days>$i){
		$init[0] = $init[0]+1;
		$genDate = generateDate($init[0],$init[1],$init[2]);
		array_push($genDate_combi, $genDate);
		// echo $init[0];
		$i++;
	}
	// echo $genDate;
	// print_r($genDate2);
	// echo $init[1];
	// echo $from;
	// echo $init[2];
	return $genDate_combi;
}

$days = daydiff($from,$to);
$genDate_combi  = calculateDates($from,$days);
// print_r($genDate_combi);
echo sizeof($genDate_combi);


?>