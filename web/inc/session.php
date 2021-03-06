<?php

$stats = Tools::calcStats(Logins::getCurrentSession());

?>

<style>
body{
    overflow:hidden;
}
</style>


<div id="popup" class="vhalign" style="display:none;position:fixed;top:0px;left:0px;height:100%;width:100%;background:rgba(0,0,0,0.5);z-index:5;">
    <div style="box-shadow:0 0 5px rgba(0,0,0,0.5);margin:15px;border-radius:4px;color:white;padding:20px;background:rgb(50,50,50);">
        <h2 style="margin-top:5px;">Be careful.</h2>
        You've reached the suggested limit of alcohol consumption for today.<br/>

        <a class="btn btn-primary" href="javascript:close_popup();"style="margin-top:20px;width:100%;">OK</a>
    </div>
</div>

<div class="first graph-holder" style="position:relative;">
    <?php $graphid = Logins::getCurrentSession(); include 'graph.php' ?>
    <div id="acc-left" class="drink-acceptor vhalign" style="left:0;">
        <span class="text">1/2 Pint</span><br/>
        <span class="ml">300ml</span>
    </div>
    <div id="acc-right" class="drink-acceptor vhalign" style="right:0;">
        <span class="text">1 Pint</span><br/>
        <span class="ml">500ml</span>
    </div>
    <div id="info" style="z-index:7;padding:30px;display:none;position:absolute;width:100%;height:100%;top:0;background:rgb(200,200,200);color:black;">

    </div>
</div>

<script type="text/javascript">
    var MAXUNITS = <?php echo Logins::getMaxUnits(); ?>;
</script>
<script src="js/session.js" type="text/javascript"></script>

<div style="overflow-y: hidden;background-color:rgba(240,240,240,0.5);">
<div class="valign" style="height:30%;overflow-X: visible;">
    <div style="white-space: nowrap;display:inline-block;">
        <?php

        $stmt = DB::get()->query("SELECT * FROM drink");

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row){ ?>
            <div class="drink valign"
                data-drinkid="<?php echo $row['drink_id']; ?>"
                data-type1="<?php echo $row['drink_type1']; ?>" data-type1-ml="<?php echo $row['drink_type1_ml']; ?>"
                data-type2="<?php echo $row['drink_type2']; ?>" data-type2-ml="<?php echo $row['drink_type2_ml']; ?>">
                <img src="images/bottles/<?php echo $row['drink_picture']; ?>" style="width:100%;padding:10px;"/>
                <div class="drink-handle"> </div>
                <div class="vhalign drink-name">
                    <?php echo str_replace("_", " ", $row['drink_name']); ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</div>
<div style="text-shadow:0 0 2px rgba(0,0,0,0.75);width:100%;margin:0;height:10%;background:rgb(50,50,50);font-size:20px;" class="second row">
    <div id="units" style="height:100%;color:white;padding:0;text-align:center;" class="col-xs-3 vhalign fader">
        <span class="value" style="font-size:25px;line-height:0.9em;"><?php echo $stats['units']; ?></span><br/>
        <span style="font-size:15px;line-height:0.9em;">units</span></div>
    <div id="calories" style="height:100%;color:white;background:rgb(60,60,60);border:1px solid rgb(50,50,50);text-align:center;padding:0;" class="col-xs-3 vhalign fader">
        <span class="value" style="font-size:25px;line-height:0.9em;"><?php echo $stats['calories']; ?></span><br/>
        <span style="font-size:15px;line-height:0.9em;">calories</span></div>
    <a id="more" href="#" style="height:100%;color:white;padding:0;border:1px solid rgb(30,30,30)" class="col-xs-6 vhalign">
        MENU <span id="menu-button" style="padding-left:5px;vertical-align:-2px;" class="glyphicon glyphicon-chevron-down"></span>
    </a>
</div>
<div style="text-shadow:0 1px 0 black;width:100%;margin:0;height:10%;background:rgb(40,40,40);font-size:20px;" class="row">
    <div style="height:100%;color:white;padding:0;text-align:center;" class="col-xs-6 vhalign">
        <div style="position:relative;font-size:16px;height:60%;width:90%;background:gray;">
            <div style="width:<?php print 100*Tools::hangoverness(Logins::getCurrentSession()); ?>%;height:100%;background:rgb(120,70,70);">
                <div style="position:absolute;left:10px;top:50%;line-height:0;">
                    Hangover <?php print round(100*Tools::hangoverness(Logins::getCurrentSession()), 2); ?>%
                </div>
            </div>
        </div>
    </div>
    <?php $uStats = Tools::calcStatsUser(Logins::getCurrentUserID()); ?>
    <div id="tot-units" style="height:100%;color:white;background:rgb(60,60,60);padding:0;text-align:center;" class="col-xs-3 vhalign fader">
        <span class="value" style="font-size:20px;line-height:0.9em;"><?php echo $uStats['units']; ?></span><br/>
        <span style="font-size:15px;line-height:0.9em;">total units</span></div>
    <div id="tot-calories" style="height:100%;color:white;border:1px solid rgb(50,50,50);text-align:center;padding:0;" class="col-xs-3 vhalign fader">
        <span class="value" style="font-size:20px;line-height:0.9em;"><?php echo $uStats['calories']; ?></span><br/>
        <span style="font-size:15px;line-height:0.9em;">total cal</span></div>
</div>


<div style="height:80%;">
    <div class="menu-buttons">
        <a href="action/endsession.php" style="background:rgb(140, 100, 0);border-bottom:1px solid rgb(80, 50, 0)">
            <div style="vertical-align:middle;">Call taxi / emergency</div>
        </a>
        <a href="action/endsession.php" style="background:rgb(20,100,20);border-bottom:1px solid rgb(10, 60, 0);">
            <div style="vertical-align:middle;">End session</div>
        </a>
    </div>

    <div id="history" class="history" style="height:70%;background-image: url('css/background2.jpg');background-repeat: no-repeat;background-size: cover;background-position: center;height: 100%;
}">
        <?php
        echo Tools::getHistory();
        ?>
    </div>
</div>
