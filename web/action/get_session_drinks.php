<?php
require_once __DIR__ . '/../init.php';

$sessionId = Logins::getCurrentSession();

$stmt = DB::get()->query('SELECT * FROM sessiondrink WHERE sessdr_session_id = ' . $sessionId . ';');

$drinks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$jsonExample = json_encode($drinks);

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo($jsonExample);
