<div class="graph-holder">
    Graph goes here...
    <div class="drink-acceptor vhalign" style="left:0;">
ho
    </div>
    <div class="drink-acceptor vhalign" style="right:0;">
hey
    </div>
</div>

<style>
.graph-holder{
    height: 60%;
    background: black;
    position: relative;
}
.drink-acceptor.hover{
    border: 4px solid rgb(60, 60, 170);
    opacity: 1;
}
.drink-acceptor.active{
    border: 15px solid white;
}

.drink-acceptor{
    position: absolute;
    width: 50%;
    height: 100%;
    top: 0;
    -webkit-transition: border ease-in-out 0.25s, opacity ease-in-out 0.15s;
    transition: border ease-in-out 0.25s, opacity ease-in-out 0.15s;
    border: 0 solid black;
    opacity: 0;
}

.drink{
    -webkit-transition: border ease-in-out 1s;
    transition: border ease-in-out 1s;
    border: 0px solid white;
    position: relative;
    margin: 0 10px;
    border-radius: 75px;
    z-index: 3;
    height: 125px;
    width: 125px;
    display: inline-block;
    background: rgb(160, 160, 160);
    box-shadow:0 2px 5px rgba(0,0,0,0.25);
}

.drink-handle{
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -50px;
    margin-top: -50px;
    border-radius: 50px;
    width: 100px;
    height: 100px;
}
</style>

<script>
$(function() {
    $( ".drink" ).draggable({
        helper: 'clone',
        appendTo: 'body',
        handle: '.drink-handle'
    });

    $( ".drink-acceptor" ).droppable({
        activeClass: "hover",
        hoverClass: "active",
        over: function( event, ui ) {
            $(ui.helper).css("border-width", "10px");
            return false;
        }
    });
});

</script>

<div style="overflow-y: scroll;background:rgb(240,240,240);">
<div class="valign" style="height:30%;overflow-X: visible;">
    <div style="white-space: nowrap;display:inline-block;">
        <?php

        $stmt = DB::get()->query("SELECT * FROM drink");

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row){ ?>
            <div class="drink valign">
                <img src="images/bottles/<?php echo $row['drink_picture']; ?>" style="width:100%;"/>
                <div class="drink-handle"> </div>
                <div class="vhalign" style="line-height:0.9em;text-align:center;pointer-events:none;font-size:18px;padding:2px;text-shadow:0 0 3px black;
                white-space:normal;border-radius:4px;position:absolute;top:0;text-transform:uppercase;width:100%;height:100%;color:white;">

                        <?php echo str_replace("_", " ", $row['drink_name']); ?>

                </div>
            </div>
        <?php } ?>
    </div>
</div>
</div>
<div style="width:100%;margin:0;height:10%;background:rgb(50,50,50);font-size:20px;" class="row">
    <div href="" style="height:100%;color:white;padding:0;" class="col-xs-3 vhalign">5.4<br/><span style="font-size:15px;">units</span></div>
    <div href="" style="height:100%;color:white;background:rgb(60,60,60);padding:0;" class="col-xs-3 vhalign"><span style="font-size:15px;">500 calories</span></div>
    <a href="" style="height:100%;color:white;padding:0;" class="col-xs-6 vhalign">Go home.</a>
</div>
