/**
 * Created by kostja on 11/8/14.
 */

var DrunkGraph = function (divElement) {
    var currentBACLine = [], worstedBACLine, bestBACLine;
    var startDateTime = null, endDateTime = null, interval = '6 hours';

    var getDataFromServer = function() {
        $.ajax({
            url: 'action/get_session_drinks.php'
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
            drinkname = drink['sessdr_drink_id'];
            currentBACLine[ currentBACLine.length ] = [drink_time, ebac_before, null];
            currentBACLine[ currentBACLine.length ] = [drink_time, ebac_after, null];

            if (startDateTime == null || startDateTime > drink_time) {
                startDateTime = drink_time;
            }

            if (endDateTime == null || endDateTime < drink_time) {
                endDateTime = drink_time;
            }
        }
        startDateTime = new Date( startDateTime.getTime() - 60*60*1000 );
        endDateTime = new Date( '2014-11-8 22:00:00' );
        currentBACLine[ currentBACLine.length ] = [endDateTime, 0, null];
        interval = parseInt((endDateTime.getTime() - startDateTime.getTime())/60/60) ;
        console.log(currentBACLine);
    };

    var setDataDump = function () { //TODO: Get real data
        worstedBACLine = new Array();//currentBACLine.slice(0);
        worstedBACLine[0] = currentBACLine[currentBACLine.length -2];
        worstedBACLine[1] = [
            ( new Date(worstedBACLine[0][0].getTime() + 10*(worstedBACLine[0][0].getTime() - currentBACLine[currentBACLine.length - 3][0].getTime())) ),
            currentBACLine[ currentBACLine.length - 2][1] + ( currentBACLine[ currentBACLine.length - 2][1] - currentBACLine[ currentBACLine.length - 3][1] ),
            null
        ];
        console.log(worstedBACLine);
        /*bestBACLine = new Array();//currentBACLine.slice(0);
         bestBACLine[0] = currentBACLine[currentBACLine.length - 1];
         var bestBACAdd = [['2014-11-8 11:00PM', 0.9, null], ['2014-11-9 00:00AM', 0.2, null], ['2014-11-9 01:00AM', 0.1, null]];
         for (i = 0; i < bestBACAdd.length; i++) {
         bestBACLine[bestBACLine.length] = bestBACAdd[i];
         }*/
    };

    var drawGraph = function() {
        $.jqplot(divElement, [currentBACLine, worstedBACLine, bestBACLine], {
            title:'EBAC',
            seriesColors: ['#00749F', '#FF0000', '#3BFF00'],
            axes:{
                xaxis:{
                    renderer:$.jqplot.DateAxisRenderer,
                    tickOptions:{formatString:'%b %#d, %#I.%M %p'},
                    min: startDateTime,
                    tickInterval: interval
                }
            },
            seriesDefaults:{
                showMarker:true,
                pointLabels:{ show:true, location:'s', ypadding:3 }
            },
            series:[]
        });
    };

    return {
        draw: function() {
            getDataFromServer();
        }
    };
};