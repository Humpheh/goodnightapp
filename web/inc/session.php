<div class="graph-holder" style="height:60%;background:black;">
    Graph goes here...
</div>

<style>
.graph-holder{
    -webkit-transition: border ease-in-out 0.25s;
    transition: border ease-in-out 0.25s;
    border: 0 solid black;
}
.hover{
    border: 4px solid blue;
}
.active{
    border: 15px solid white;
}

.drink{
    -webkit-transition: border ease-in-out 1s;
    transition: border ease-in-out 1s;
    border: 0px solid white;
    position: relative;
    margin: 0 10px;
    border-radius: 75px;
    z-index: 3;
    height: 150px;
    width: 150px;
    display: inline-block;
    background: red;
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

    $( ".graph-holder" ).droppable({
        activeClass: "hover",
        hoverClass: "active",
        over: function( event, ui ) {
            $(ui.helper).css("border-width", "10px");
            return false;
        }
    });
});

</script>

<div style="overflow-y: scroll;">
<div class="valign" style="height:30%;overflow-X: visible;">
    <div style="white-space: nowrap;display:inline-block;">
        <?php for ($i = 0; $i < 10; $i++){ ?>
            <div class="drink valign">
                <div class="drink-handle"> </div>
                DRINK?
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
