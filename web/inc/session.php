<?php

$stats = Tools::calcStats(Logins::getCurrentSession());

?>

<div class="first graph-holder" style="position:relative;">
    <?php include 'graph.php' ?>
    <div id="acc-left" class="drink-acceptor vhalign" style="left:0;">
        <span class="text">1/2 Pint</span><br/>
        <span class="ml">300ml</span>
    </div>
    <div id="acc-right" class="drink-acceptor vhalign" style="right:0;">
        <span class="text">1 Pint</span><br/>
        <span class="ml">500ml</span>
    </div>
    <div id="info" style="padding:30px;display:none;position:absolute;width:100%;height:100%;top:0;background:rgb(200,200,200);">

    </div>
</div>

<script type="text/javascript">
var scrolled = false;
    $("document").ready(function() {

        $('#more').click(function(e){
            e.preventDefault();
          $('html, body').animate({
            scrollTop: $(scrolled ? ".first" : ".second").offset().top
          }, 500);
        scrolled = !scrolled;
        $('#menu-button').toggleClass("glyphicon-chevron-down glyphicon-chevron-up");
    });
});
</script>

<style>
body{
    overflow:hidden;
    background-image: url('css/background2.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    height: 100%;
}

.graph-holder{
    height: 60%;
    position: relative;
    color:rgb(195, 193, 193);
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

.fader{
    -webkit-transition: background ease-in-out 0.5s;
    transition: background ease-in-out 0.5s;
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

    $( ".drink" ).click(function(e){
        $.post( "action/getdrinkinfo.php", {
            drinkid: $(this).data( "drinkid" )
        }).done(function( data ) {
            $('#info').html(data);

            $("#info").slideDown();
        });
    });

    $('#info').on('click', '#close-info', function(e){
        $("#info").slideUp();
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
                var graph = DrunkGraph('drunkChart');
                $('#drunkChart').html("");
                graph.draw();

                per = obj.units / <?php echo Logins::getMaxUnits(); ?>;
                col = getColorForPercentage(per);
                $('#units').css('background', col);

                $("#history").html(obj.history);
            });

        }
    });
});

var percentColors = [,
    { pct: 0.0, color: { r: 0x00, g: 0xff, b: 0 } },
    { pct: 0.5, color: { r: 0xff, g: 0xff, b: 0 } },
    { pct: 1.0, color: { r: 0xff, g: 0x00, b: 0 } }];

var getColorForPercentage = function(pct) {
    for (var i = 1; i < percentColors.length - 1; i++) {
        if (pct < percentColors[i].pct) {
            break;
        }
    }
    var lower = percentColors[i - 1];
    var upper = percentColors[i];
    var range = upper.pct - lower.pct;
    var rangePct = (pct - lower.pct) / range;
    var pctLower = 1 - rangePct;
    var pctUpper = rangePct;
    var color = {
        r: Math.floor(lower.color.r * pctLower + upper.color.r * pctUpper),
        g: Math.floor(lower.color.g * pctLower + upper.color.g * pctUpper),
        b: Math.floor(lower.color.b * pctLower + upper.color.b * pctUpper)
    };
    return 'rgb(' + [color.r, color.g, color.b].join(',') + ')';
    // or output as hex if preferred
}

</script>

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
<div style="text-shadow:0 1px 0 rgba(0,0,0,0.5);width:100%;margin:0;height:10%;background:rgb(50,50,50);font-size:20px;" class="second row">
    <div id="units" href="" style="height:100%;color:white;padding:0;text-align:center;" class="col-xs-3 vhalign fader">
        <span class="value" style="font-size:25px;line-height:0.9em;"><?php echo $stats['units']; ?></span><br/>
        <span style="font-size:15px;line-height:0.9em;">units</span></div>
    <div id="calories" href="" style="height:100%;color:white;background:rgb(60,60,60);border:1px solid rgb(50,50,50);text-align:center;padding:0;" class="col-xs-3 vhalign fader">
        <span class="value" style="font-size:25px;line-height:0.9em;"><?php echo $stats['calories']; ?></span><br/>
        <span style="font-size:15px;line-height:0.9em;">calories</span></div>
    <a id="more" href="#" style="height:100%;color:white;padding:0;border:1px solid rgb(30,30,30)" class="col-xs-6 vhalign">
        MENU <span id="menu-button" style="padding-left:5px;vertical-align:-2px;" class="glyphicon glyphicon-chevron-down"></span>
    </a>
</div>

<style>
    .menu-buttons a{
        display: block;
        height: 15%;
        width: 100%;
        background: rgb(60, 60, 60);
        text-align: center;
        color: white;
        font-size: 25px;
        text-transform: uppercase;
    }
    .menu-buttons a:nth-child(even){
        background: rgb(50, 50, 50);
    }
    .menu-buttons a div{
        line-height: 0;
        position: relative;
        top: 50%;
    }

    .history{
        height: 55%;
        overflow-y: scroll;
    }
    .history .history-item{
        color:white;text-shadow:0 1px 0 black;font-size:20px;background:rgb(100, 100, 100);height:60px;
    }
    .history .history-item:nth-child(even){
        background:rgb(120, 120, 120);
    }
    .history .history-item .x{
        margin:0;padding:0;
    }
    .history .history-item .x .vhalign{
        color:white;padding:0;float:right;height:60px;width:60px;background:rgb(170, 50, 50);
    }
    .history .history-item .text {
        color:white;height:100%;padding-left:15px;
        line-height: 0.9em;
    }
    .history .history-item .stat{
        margin-right:20px;font-size:15px;
        line-height: 0.9em;
    }
    .history a:hover{
        text-decoration: none;
    }
</style>

<div style="height:90%;">
    <div class="menu-buttons">
        <a href="action/endsession.php">
            <div style="vertical-align:middle;">Emergency</div>
        </a>
        <a href="action/endsession.php">
            <div style="vertical-align:middle;">Call taxi</div>
        </a>
        <a href="action/endsession.php">
            <div style="vertical-align:middle;">Nights over</div>
        </a>
    </div>

    <div id="history" class="history">
        <?php
        echo Tools::getHistory();
        ?>
    </div>
</div>
