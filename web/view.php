<?php

require 'init.php';


if (!isset($_GET['id'])){
    header("Location: index.php");
    exit();
}
$id = intval($_GET['id']);
$stats = Tools::calcStats($id);

$stmt = DB::get()->prepare("SELECT * FROM session WHERE session_id = ?");
$stmt->bindValue(1, $id, PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

require 'header.php';
?>

<div class="first graph-holder" style="position:relative;">
    <?php
    include 'inc/graph.php';
    ?>
</div>

<script type="text/javascript">
    var MAXUNITS = <?php echo Logins::getMaxUnits(); ?>;
</script>
<script src="js/session.js" type="text/javascript"></script>

<div class="vhalign" style="font-size:18px;height:10%;line-height:1em;background:rgb(60,60,60);color:white;text-align:center;">
    <?php
    $timestamp = strtotime($row['session_timestart']);
    $time = date("D jS M Y", $timestamp);
    $date = date("H:i", $timestamp);

    $timestampE = strtotime($row['session_timefinish']);
    $timeE = date("D jS M Y", $timestampE);
    $dateE = date("H:i", $timestampE);

    echo '<b>' . $time . '</b> at <b>' . $date . '</b> to<br/><b>' . $timeE . '</b> at <b>' . $dateE . '</b>'; ?>
</div>
<div style="height:20%;">
    <div id="history" class="history" style="height:100%">
        <?php
        echo Tools::getHistory($id);
        ?>
    </div>
</div>


<div style="text-shadow:0 1px 0 rgba(0,0,0,0.5);width:100%;margin:0;height:10%;background:rgb(50,50,50);font-size:20px;" class="second row">
    <div id="units" href="" style="height:100%;color:white;padding:0;text-align:center;" class="col-xs-3 vhalign fader">
        <span class="value" style="font-size:25px;line-height:0.9em;"><?php echo $stats['units']; ?></span><br/>
        <span style="font-size:15px;line-height:0.9em;">units</span></div>
    <div id="calories" href="" style="height:100%;color:white;background:rgb(60,60,60);border:1px solid rgb(50,50,50);text-align:center;padding:0;" class="col-xs-3 vhalign fader">
        <span class="value" style="font-size:25px;line-height:0.9em;"><?php echo $stats['calories']; ?></span><br/>
        <span style="font-size:15px;line-height:0.9em;">calories</span></div>
    <a href="index.php" style="height:100%;color:white;padding:0;border:1px solid rgb(30,30,30)" class="col-xs-6 vhalign">
        BACK TO MENU
    </a>
</div>

<?php include 'footer.php'; ?>
