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
    // YOUR CODE GOES HERE
}

function users_with_top_score_on_date($pdo, $date)
{
    // YOUR CODE GOES HERE
}

function times_user_beat_overall_daily_average($pdo, $user_id)
{
    // YOUR CODE GOES HERE
}
