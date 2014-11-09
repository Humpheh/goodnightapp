<div id="landing">
<div class="valign1" style="padding-bottom: 15px;" >
    <div>
        <span style="top: 5px;position: relative;left: 5px;">
            <a href="logout.php">Logout</a>
        </span>
        <center>
            <span style="padding-bottom:15px;font-weight: bold;font-style: italic;font-size:20px;color:rgb(195, 193, 193);">Welcome back <b><?php echo Logins::getCurrentUsername(); ?></b>.</span><br>
        </center>
    </div>
</div>
<style>
    .session-list .session{
        background: rgb(50, 50, 50);
        margin: 0;
        padding: 20px;
    }
    .session-list .session:nth-child(even){
        background: rgb(40, 40, 40);
    }
</style>
<div style="height:65%;overflow:scroll;overflow-x:hidden;" class="session-list">
    <?php

    $stmt = DB::get()->prepare("SELECT * FROM session WHERE session_user_id = ?
        ORDER BY session_timestart DESC");
    $stmt->bindValue(1, Logins::getCurrentUserID(), PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        $timestamp = strtotime($row['session_timestart']);
        $time = date("D jS M Y", $timestamp);
        $date = date("H:i", $timestamp);
        ?>

        <a href="view.php?id=<?php echo $row['session_id']; ?>" class="row session valign">
            <div class="col-xs-8" style="padding:0;color:white;">
                <span style="font-size:30px;line-height:0.95em;"><?php echo $date; ?></span><br/>
                <?php echo $time; ?>
            </div>
            <div class="col-xs-4" style="padding:0;text-align:right;color:rgb(200,200,200);">
                <span style="font-size:25px;line-height:0.95em;">
                    <?php echo $row['session_calories']; ?> / <?php echo $row['session_unit']; ?>
                </span><br/>
                calories / units
            </div>
        </a>

        <?php
    } ?>
</div>
<form action="action/newsession.php" method="POST" style="color:white;font-size:17px;text-align:center;padding:10px;">
    I want to be sober by
    <select name="hr">
        <option value="-1">-</option>
        <?php for ($i = 0; $i < 24; $i++) echo '<option value="'.$i.'">' . $i . '</option>'; ?>
    </select>
    <select name="min">
        <option value="-1">-</option>
        <?php for ($i = 0; $i < 60; $i+=15) echo '<option value="'.$i.'">' . $i . '</option>'; ?>
    </select>
    tomorrow.

    <div style="position:fixed;bottom:4%;width:100%;">
        <a style="cursor:pointer;font-size:20px;" onclick="document.forms[0].submit()" style="display:table;width:100%;height:100%;text-align:center;">
        <center><span style="color:#428bca;font-size:60px;" class="glyphicon glyphicon-plus"></span></center>

        <!--<span style="color:#428bca;vertical-align:middle;font-size:80px;" class="glyphicon glyphicon-plus">Start Session</span>-->
    </a>
    </div>
</form>
</div>
