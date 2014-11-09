<?php

include '../init.php';

$stmt = DB::get()->prepare("DELETE FROM sessiondrink
    WHERE sessdr_session_id = ?
    ORDER BY sessdr_time DESC
    LIMIT 1");
$stmt->bindValue(1, Logins::getCurrentSession(), PDO::PARAM_INT);
$stmt->execute();

echo Tools::getHistory();
