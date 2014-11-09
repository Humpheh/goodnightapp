<?php

class Tools {
    public static function calcStats($sessionid){
        $stmt = DB::get()->prepare("SELECT sessiondrink.*, drink.* FROM sessiondrink
            LEFT JOIN drink ON sessdr_drink_id = drink_id
            WHERE sessdr_session_id = ?");
        $stmt->bindValue(1, $sessionid, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $calories = 0.0;
        $units = 0.0;

        $count = 0;
        foreach ($result as $row){
            $calories += floatval($row['sessdr_volume'])/1000 * floatval($row['drink_calories']);
            $units += floatval($row['sessdr_volume']) * floatval($row['drink_percent']) / 1000;
            $count++;
        }

        return array(
            "calories" => round($calories),
            "units" => round($units,1),
            "count" => $count);
    }

    public static function getHistory($id = NULL){
        if ($id == NULL) $id = Logins::getCurrentSession();

        $stmt = DB::get()->prepare("SELECT sessiondrink.*, drink.* FROM sessiondrink
            LEFT JOIN drink ON sessdr_drink_id = drink_id
            WHERE sessdr_session_id = ?
            ORDER BY sessdr_time DESC");
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $out = "";

        foreach ($result as $row){

            $out .= '<div class="history-item">';
            if($row == reset($result) && !Logins::isSessionTemp()){
                $out .= '<a href="#" class="x remove-last-button">
                <div class="vhalign"><span class="glyphicon glyphicon-remove"></span></div>
                </a>';
            }

            $out .= '<a class="text valign">
                <strong>' . str_replace("_", " ", ucfirst($row['drink_name'])) . '</strong>
                <span class="small">(' . $row['sessdr_volume'] . 'ml)</span><br/>
                <span class="stat">+' . round(floatval($row['sessdr_volume']) * floatval($row['drink_percent']) / 1000, 1) . ' units</span>
                <span class="stat">+' . round(floatval($row['sessdr_volume'])/1000 * floatval($row['drink_calories'])) . ' calories</span>
                </a>
                </div>';

        }
        return $out;
    }

    public static function ebac($sum, $gender, $weight, $DP){
        $BW = ($gender == "female") ? 0.49 : 0.58;
        $MR = ($gender == "female") ? 0.017 : 0.015;

        $top = 0.806 * (1/12.7) * $sum * 1.2;
        $bot = $BW * $weight;
        return ($top / $bot) - ($MR * $DP);
    }

    public static function hangoverness($sessionid){
        $bstmt = DB::get()->prepare("SELECT * FROM session WHERE session_id = ?");
        $bstmt->bindValue(1, $sessionid, PDO::PARAM_INT);
        $bstmt->execute();
        $sess = $bstmt->fetch(PDO::FETCH_ASSOC);

        $stmt = DB::get()->prepare("SELECT sessiondrink.*, drink.* FROM sessiondrink
            LEFT JOIN drink ON sessdr_drink_id = drink_id
            WHERE sessdr_session_id = ?
            ORDER BY sessdr_ebac_after DESC");

        $stmt->bindValue(1, $sessionid, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pv1 = 0.2;
        $pv2 = 1.6;

        $max = -1;
        $earliest = -1;
        $latest = -1;
        $hangover = 0;
        $count = 0;
        $water = 0;
        foreach ($result as $row){
            if ($max == -1){ $max = $row['sessdr_ebac_after']; }
            if ($earliest == -1 || strtotime($row['sessdr_time']) < $earliest) $earliest = strtotime($row['sessdr_time']);
            if ($latest == -1 || strtotime($row['sessdr_time']) > $latest) $latest = strtotime($row['sessdr_time']);
            $hangover += floatval($row['drink_congener']);
            $count++;
            if ($row['drink_name'] == "water") $water += $row['sessdr_volume'];
        }

        if ($count == 0) return 0;

        $w = $count/4;

        $t = (($latest+1 - $earliest)/3600);
        if ($t <= 1 ) $t = 1;
        $dtime = $w * (1 / $t);



        $result = $dtime + ($max / $pv1) + ($hangover / ($count * 16)) - ($water / 4000);

        echo $result . ' ';
        echo $dtime . ' ';
        echo $max . ' ';
        echo $pv1 . ' ';
        echo $hangover . ' ';
        echo $count . ' ';
        echo $t . ' ';


        $result /= ($pv2 + ($t-3)/6);


        return $result;
    }
}
