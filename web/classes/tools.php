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

        foreach ($result as $row){
            $calories += floatval($row['sessdr_volume'])/1000 * floatval($row['drink_calories']);
            $units += floatval($row['sessdr_volume']) * floatval($row['drink_percent']) / 1000;
        }

        return array(
            "calories" => round($calories),
            "units" => round($units,1));
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
            if($row == reset($result) && $id == Logins::getCurrentSession()){
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

}
