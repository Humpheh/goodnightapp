/**
 * Created by kostja on 11/8/14.
 */

var DrunkGraph = function (divElement) {
    var currentBACLine = [], worstedBACLine, bestBACLine, maxLine = [];
    var startDateTime = null, endDateTime = null, interval = '6 hours';

    var getDataFromServer = function() {
        $.ajax({
            url: 'action/get_session_drinks.php?id=' + sid
        }).success(function(data) {
            console.log(data);
            setData(data);
            //setDataDump();
            drawGraph();
        });
    };

    var setData = function (data) {
        var drink = null;
        var drink_time = null;
        var ebac_before = 0;
        var ebac_after = 0;
        var drinkname = 0;
        for (var i = 0; i < data.length; i++) {
            drink = data[i];
            drink_time = new Date(drink['sessdr_time']);
            ebac_before = parseFloat(drink['sessdr_ebac_before']);
            ebac_after = parseFloat(drink['sessdr_ebac_after']);
            drinkname = drink['drink_name'];
            currentBACLine[ currentBACLine.length ] = [drink_time, ebac_before, drinkname];
            currentBACLine[ currentBACLine.length ] = [drink_time, ebac_after, null];
            maxLine[ maxLine.length ] = [drink_time, 0.4, null];
            if (startDateTime == null || startDateTime > drink_time) {
                startDateTime = drink_time;
            }

            if (endDateTime == null || endDateTime < drink_time) {
                endDateTime = drink_time;
            }
        }
        if (endOfAlcohol != null && endOfAlcohol > endDateTime)
            endDateTime = endOfAlcohol;

        var holeDuration =  endDateTime.getTime() - startDateTime.getTime();
        startDateTime = new Date(startDateTime.getTime() - holeDuration * 0.1);
        interval = parseInt((endDateTime.getTime() - startDateTime.getTime())/60/60) ;
    };

    var setDataDump = function () {

    };

    var drawGraph = function() {
        $.jqplot(divElement, [maxLine, currentBACLine, worstedBACLine, bestBACLine], {
            title:'EBAC',
            seriesColors: ['#969696', '#00749F', '#FF0000', '#3BFF00'],
            axes:{
                xaxis:{
                    renderer:$.jqplot.DateAxisRenderer,
                    tickOptions:{formatString:'%#H:%M'},
                    min: startDateTime,
                    tickInterval: interval
                }
            },
            seriesDefaults:{
                showMarker:true,
                pointLabels:{ show:true, location:'s', ypadding:3 }
            },
            series:[
                {showMarker: false}
            ]
        });
    };

    return {
        draw: function() {
            getDataFromServer();
        }
    };
};
