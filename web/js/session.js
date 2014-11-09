
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

                per = obj.units / MAXUNITS;
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
