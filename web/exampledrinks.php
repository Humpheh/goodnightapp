<?php

$example = array(
    array(
        "sessdr_id" => 1,
        "sessdr_time" => "2014-11-08 15:32:09",
        "sessdr_volume" => 500,
        "drink_name" => "shot",
        "drink_percentage" => 0.6
    ),
    array(
        "sessdr_id" => 2,
        "sessdr_time" => "2014-11-08 15:35:20",
        "sessdr_volume" => 500,
        "drink_name" => "beer",
        "drink_percentage" => 0.4
    ),
    array(
        "sessdr_id" => 3,
        "sessdr_time" => "2014-11-08 15:37:59",
        "sessdr_volume" => 200,
        "drink_name" => "beer",
        "drink_percentage" => 0.2
    )
);

$jsonExample = json_encode($example);

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo($jsonExample);
