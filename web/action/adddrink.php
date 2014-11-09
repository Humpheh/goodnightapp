<?php

include '../init.php';

function ebac($sum, $gender, $weight, $DP){
    $BW = ($gender == "female") ? 0.49 : 0.58;
    $MR = ($gender == "female") ? 0.017 : 0.015;

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
        $sum += floatval($row['sessdr_volume']) * (floatval($row['drink_percent']) / 100);
    }

    $sd = $sum;
    return array(
        "sum" => $sum,
        "time" => $start);
}

$sessionid = Logins::getCurrentSession();

$drinkid = intval($_POST['drinkid']);
$volume = floatval($_POST['volume']);

// get the percentage of the drink from the database
$per = DB::get()->prepare("SELECT drink_percent FROM drink WHERE drink_id = ?" );
$per->bindValue(1, $drinkid, PDO::PARAM_INT);
$per->execute();
$percent = floatval($per->fetch(PDO::FETCH_ASSOC)['drink_percent']) / 100;


$oSum = calcSum($sessionid);
$time = (time()-$oSum["time"]) / (60*60);

$oldEbac = ebac($oSum["sum"], Logins::getCurrentUserGender(), Logins::getCurrentUserWeight(), $time);

//print_r($oSum);
//exit();

// if old ebac less than 0, set start time to current time
if ($oldEbac <= 0){
    $time = 0;
    $oldEbac = 0;
    $oSum["sum"] = 0;
}

// find new sum
$nSum = $oSum["sum"] + floatval($volume) * floatval($percent);

// calculate new ebac
$newEbac = ebac($nSum, Logins::getCurrentUserGender(), Logins::getCurrentUserWeight(), $time);


$stmt = DB::get()->prepare("INSERT INTO sessiondrink
    (sessdr_session_id, sessdr_drink_id, sessdr_volume, sessdr_ebac_before, sessdr_ebac_after)
    VALUES (?, ?, ?, ?, ?)");
$stmt->bindValue(1, $sessionid, PDO::PARAM_INT);
$stmt->bindValue(2, $drinkid, PDO::PARAM_INT);
$stmt->bindValue(3, $volume, PDO::PARAM_INT);
$stmt->bindValue(4, $oldEbac, PDO::PARAM_STR);
$stmt->bindValue(5, $newEbac, PDO::PARAM_STR);
$stmt->execute();

$stats = Tools::calcStats($sessionid);

$json = "{";
$json .= '"oldEbac" : ' . $oldEbac . ',';
$json .= '"newEbac" : ' . $newEbac . ',';
$json .= '"units" : ' . $stats['units'] . ',';
$json .= '"calories" : ' . $stats['calories'] . ',';
$json .= '"history" : ' . json_encode(Tools::getHistory()) . '';
$json .= '}';

echo $json;
