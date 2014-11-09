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
}
