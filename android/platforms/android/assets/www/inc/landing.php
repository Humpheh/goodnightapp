<div style="height:50%;">
    <a href="" style="background:brown;display:table;width:100%;height:100%;text-align:center;">
        <span style="color:white;display:table-cell;vertical-align:middle;font-size:80px;" class="glyphicon glyphicon-plus"></span>
    </a>
</div>

<style>
    .session-list .session{
        background: rgb(50, 50, 50);


        /* Internet Explorer 10 */
        display:-ms-flexbox;
        -ms-flex-align:center;

        /* Firefox */
        display:-moz-box;
        -moz-box-align:center;

        /* Safari, Opera, and Chrome */
        display:-webkit-box;
        -webkit-box-align:center;

        /* W3C */
        display:box;
        box-align:center;

        margin: 0;
        padding: 20px;
    }
    .session-list .session:nth-child(even){
        background: rgb(40, 40, 40);
    }
</style>

<div style="height:50%;overflow:scroll;" class="session-list">
    <?php

    $stmt = DB::get()->prepare("SELECT * FROM session WHERE session_user = ?");
    $stmt->bindValue(1, Logins::getCurrentUserID(), PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
        $timestamp = strtotime($row['session_timestart']);
        $time = date("D jS M Y", $timestamp);
        $date = date("H:i", $timestamp);

        ?>

        <div class="row session">
            <div class="col-xs-9" style="padding:0;">
                <span style="font-size:30px;line-height:0.95em;"><?php echo $date; ?></span><br/>
                <?php echo $time; ?>
            </div>
            <div class="col-xs-3" style="padding:0;text-align:right;color:rgb(200,200,200);">
                <span style="font-size:25px;line-height:0.95em;">250</span><br/>
                calories
            </div>
        </div>

        <?php
    } ?>
</div>
    You are logged in as <?php echo Logins::getCurrentUsername(); ?>. <a href="logout.php">Logout</a>
