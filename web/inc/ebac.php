<?php

include '../init.php';

function ebac($sum, $gender, $weight, $DP){
    $BW = ($gender == "female") ? 0.49 : 0.58;
    $MR = 0.017;

    $top = 0.806 * (1/12.7) * $sum * 1.2;
    $bot = $BW * $weight;
    return ($top / $bot) - ($MR * $DP);
}

// when adding drink
    // get ebac up to this point
    // if less than or equal to 0, reset time to 0
    // calculate new ebac with new drink added

function calcSum($sessionid){
    $stmt = DB::get()->prepare("SELECT sessiondrink.*, drink.* FROM sessiondrink
        LEFT JOIN drink ON sessdr_drink_id = drink_id
        WHERE sessdr_session_id = ?");
    $stmt->bindValue(1, $sessionid, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $start = time();
    $sum = 0;

    foreach ($result as $row){
        // if ebac was 0 or less, then set start time to that.
        if ($row['sessdr_ebac_before'] <= 0) {
            $start = strtotime($row['sessdr_time']);
            $sum = 0;
        }
        $sum += floatval($row['sessdr_volume']) * floatval($row['drink_percent']);
    }

    $sd = $sum;
    return array(
        "SD" => $sum,
        "TIME" => $start);
}

$newDrink = array("sessdr_volume" => 100, "drink_percentage" => 0.5);

$oSum = calcSum(1);
$time = (time()-$oSum["TIME"]) / 60;
$oldEbac = ebac($oSum["SD"], Logins::getCurrentUserGender(), Logins::getCurrentUserWeight(), $time);
/*
// if old ebac less than 0, set start time to current time
if ($oldEbac <= 0) $time = 0;

// find new sum
$nSum = $oSum["SD"] + floatval($newDrink['sessdr_volume']) * floatval($newDrink['drink_percentage']);

// calculate new ebac
$newEbac = ebac($nSum["SD"], Logins::getCurrentUserGender(), Logins::getCurrentUserWeight(), $time);
*/
echo $oldEbac;//. ' ' . $newEbac;
