<?php
require_once __DIR__ . '/../init.php';

$sessionId = intval($_GET['graphid']);//Logins::getCurrentSession();

$stmt = DB::get()->prepare("SELECT * FROM sessiondrink LEFT JOIN drink ON drink_id = sessdr_drink_id WHERE sessdr_session_id = ?;");
$stmt->bindValue(1, $sessionId, PDO::PARAM_INT);
$stmt->execute();

$drinks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$jsonExample = json_encode($drinks);

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo($jsonExample);
