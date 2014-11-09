<?php

$stats = Tools::calcStats(Logins::getCurrentSession());

?>

<div class="graph-holder">
    <?php include 'graph.php' ?>
    <div id="acc-left" class="drink-acceptor vhalign" style="left:0;">
        <span class="text">1/2 Pint</span><br/>
        <span class="ml">300ml</span>
    </div>
    <div id="acc-right" class="drink-acceptor vhalign" style="right:0;">
        <span class="text">1 Pint</span><br/>
        <span class="ml">500ml</span>
    </div>
</div>

<style>
.graph-holder{
    height: 60%;
    background: black;
    position: relative;
}
.drink-acceptor.hover{
    border: 4px solid rgba(255,255,255,0.5);
    opacity: 1;
}
.drink-acceptor.active{
    border: 10px solid white;
    background: rgba(0, 0, 0, 0.75);
}

.drink-acceptor{
    text-align:center;
    position: absolute;
    width: 50%;
    height: 100%;
    top: 0;
    background: rgba(0, 0, 0, 0.4);
    -webkit-transition: border ease-in-out 0.25s, opacity ease-in-out 0.15s, background ease-in-out 0.15s;
    transition: border ease-in-out 0.25s, opacity ease-in-out 0.15s, background ease-in-out 0.15s;
    border: 0 solid black;
    opacity: 0;
}

.drink-acceptor .text{
    font-size: 28px;
    line-height: 0.9em;
    text-transform: uppercase;
    font-weight: bold;
    color: white;
}
.drink-acceptor .ml{
    font-size: 18px;
    color: rgb(230, 230, 230);
}

.drink{
    -webkit-transition: border ease-in-out 0.1s;
    transition: border ease-in-out 0.1s;
    border: 0px solid white;
    position: relative;
    margin: 0 10px;
    border-radius: 75px;
    z-index: 3;
    height: 125px;
    width: 125px;
    display: inline-block;
    background: rgb(160, 160, 160);
    /*box-shadow:0 2px 5px rgba(0,0,0,0.25);*/
}

.drink-name{
    line-height:0.9em;text-align:center;pointer-events:none;font-size:18px;padding:2px;text-shadow:0 0 3px black;
    white-space:normal;border-radius:4px;position:absolute;top:0;text-transform:uppercase;width:100%;height:100%;color:white;
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
.drink.sel{
    box-shadow: 0 2px 5px rgba(0,0,0,0.25);
}
</style>

<script>
$(function() {
    $( ".drink" ).draggable({
        helper: 'clone',
        appendTo: 'body',
        handle: '.drink-handle',
        scroll: false
    });

    $( ".drink-acceptor" ).droppable({
        activeClass: "hover",
        hoverClass: "active",
        activate: function( event, ui ) {
            $('#acc-left .text').html( $(ui.draggable).data( "type1" ) );
            $('#acc-left .ml').html( $(ui.draggable).data( "type1-ml" ) + "ml");

            $('#acc-right .text').html( $(ui.draggable).data( "type2" ) );
            $('#acc-right .ml').html( $(ui.draggable).data( "type2-ml" ) + "ml");

            $(ui.helper).addClass("sel");
        },
        over: function( event, ui ) {
            $(ui.helper).css("border-width", "5px");
            return false;
        },
        drop: function (event, ui){
            var vol = $(this).attr('id') === "acc-left" ?
                $(ui.draggable).data( "type1-ml" ) :
                $(ui.draggable).data( "type2-ml" );

            $.post( "action/adddrink.php", {
                drinkid: $(ui.draggable).data( "drinkid" ),
                volume: vol
            }).done(function( data ) {
                var obj = jQuery.parseJSON( data );

                $("#units .value").html(obj.units);
                $("#calories .value").html(obj.calories);
            });

        }
    });
});

</script>

<div style="overflow-y: hidden;background:rgb(240,240,240);">
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
<div style="width:100%;margin:0;height:10%;background:rgb(50,50,50);font-size:20px;" class="row">
    <div id="units" href="" style="height:100%;color:white;padding:0;text-align:center;" class="col-xs-3 vhalign">
        <span class="value" style="font-size:25px;line-height:0.9em;"><?php echo $stats['units']; ?></span><br/>
        <span style="font-size:15px;line-height:0.9em;">units</span></div>
    <div id="calories" href="" style="height:100%;color:white;background:rgb(60,60,60);text-align:center;padding:0;" class="col-xs-3 vhalign">
        <span class="value" style="font-size:25px;line-height:0.9em;"><?php echo $stats['calories']; ?></span><br/>
        <span style="font-size:15px;line-height:0.9em;">calories</span></div>
    <a href="action/endsession.php" style="height:100%;color:white;padding:0;" class="col-xs-6 vhalign">Go home.</a>
</div>
