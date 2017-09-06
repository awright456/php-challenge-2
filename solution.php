<?php
// Amy Wright
// axw4424@gmail.com

function parse_request($request, $secret)
{
    // decodes the request by undoing what was done in make_request
	$str = strtr($request, '-_', '+/');
	$str = explode(".", $str);
	assert( count($str) == 2);
	
	$signature = base64_decode($str[0]);
	$payload = base64_decode($str[1]);
	$payload = json_decode($payload, true);
	
	return $payload;
	
	
		
}

function dates_with_at_least_n_scores($pdo, $n)
{
    // fetches the dates in the database which have scores greater than or equal to n
	return  $pdo->query("SELECT DISTINCT date FROM scores WHERE score >= $n ORDER BY date DESC")->fetchAll(PDO::FETCH_COLUMN);
}

function users_with_top_score_on_date($pdo, $date)
{
    // fetches the top scores on a date, then gets the user id for that top score on that date
	return $pdo->query("SELECT user_id FROM scores WHERE date = '$date' AND score  IN  ( SELECT MAX(score) FROM scores WHERE date = '$date')")->fetchAll(PDO::FETCH_COLUMN);
}

function times_user_beat_overall_daily_average($pdo, $user_id)
{
    // get days the user played
	$days_played = $pdo->query("SELECT date FROM scores WHERE user_id = $user_id")->fetchAll(PDO::FETCH_COLUMN);
	$counter = 0;
	//echo var_export($days_played);
	//get the average on those days
	//if the players score is greater than the average, add 1 to the count
	foreach( $days_played as $day)
	{
		echo 'day:'.var_export($day);
		$average = $pdo->query("SELECT AVG(score) FROM scores WHERE date = '$day'" )->fetchAll(PDO::FETCH_COLUMN);
		$score =  $pdo->query("SELECT score FROM scores WHERE date = '$day' AND user_id = $user_id" )->fetchAll(PDO::FETCH_COLUMN);
		
		//echo '-average:'.var_export($average);
		//echo '-score:'.var_export($score);
		echo $score[0] > $average[0];
		if( $score[0] > $average[0])
			$counter++;
		
	}
	echo 'counter'.$counter;
	return $counter;
	
}
