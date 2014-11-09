/**
 * Created by kostja on 11/8/14.
 */

var DrunkGraph = function (divElement) {
    var currentBACLine = [], worstedBACLine, bestBACLine = [], maxLine = [];
    var startDateTime = null, endDateTime = null, interval = '6 hours';

    var getDataFromServer = function() {
        $.ajax({
            url: 'action/get_session_drinks.php?graphid=' + graphid
        }).success(function(data) {
            console.log(data);
            setData(data);
            drawGraph();
        });
    };
    var ultimateMax;
    var ultimateTime;
    var setData = function (data) {
        var drink = null;
        var drink_time = null;
        var ebac_before = 0;
        var ebac_after = 0;
        var drinkname = 0;
        var userMaxAlc = 0;
        for (var i = 0; i < data.length; i++) {
            drink = data[i];
            drink_time = new Date(drink['sessdr_time']);
            ebac_before = parseFloat(drink['sessdr_ebac_before']);
            ebac_after = parseFloat(drink['sessdr_ebac_after']);
            drinkname = drink['drink_name'];
            currentBACLine[ currentBACLine.length ] = [drink_time, ebac_before, drinkname];
            currentBACLine[ currentBACLine.length ] = [drink_time, ebac_after, null];
            if (startDateTime == null || startDateTime > drink_time) {
                startDateTime = drink_time;
            }

            if (endDateTime == null || endDateTime < drink_time) {
                endDateTime = drink_time;
            }

            if (userMaxAlc < ebac_after )
                userMaxAlc = ebac_after;
        }
        ultimateMax = userMaxAlc;
        endDateTime = new Date( endDateTime.getTime() + 60*60*1000*2 );
        ultimateTime = endDateTime;
        var holeDuration =  endDateTime.getTime() - startDateTime.getTime();
        startDateTime = new Date(startDateTime.getTime() - holeDuration * 0.1);
        interval = parseInt((endDateTime.getTime() - startDateTime.getTime())/60/60) ;

        var startTime = currentBACLine[0][0];
        worstedBACLine = [];
        maxAlcohol = ((endOfAlcohol.getTime() - startTime.getTime()) / 1000/60/60)* 0.017;
        maxAlcoholUser = (userMaxAlc > maxAlcohol) ? userMaxAlc: maxAlcohol;
        maxAlcoholUser = maxAlcoholUser * 1.2;
        worstedBACLine[ worstedBACLine.length ] = [startDateTime,maxAlcohol, null];
        worstedBACLine[ worstedBACLine.length ] = [endOfAlcohol, 0, null];
        maxLine[ maxLine.length ] = [startDateTime, maxAlcoholUser, null];
        maxLine [ maxLine.length ] = [endOfAlcohol, maxAlcoholUser, null];

        bestBACLine [ bestBACLine.length ] = [startDateTime, maxBac, null];
        bestBACLine [ bestBACLine.length ] = [endOfAlcohol, maxBac, null];
    };

    var drawGraph = function() {
        $.jqplot(divElement, [maxLine, worstedBACLine,currentBACLine, bestBACLine], {
            title:'EBAC',
            seriesColors: ['#F24c4f', '#3cb878', '#FFFFFF', '#fff568'],
            axesDefaults: {
                labelOptions: {
                    fontFamily: 'Helvetica Neue',
                    textColor: '#ffffff'
                },
                tickOptions: {
                    fontFamily: 'Helvetica Neue',
                    textColor: '#ffffff'
                }
            },
            axes:{
                xaxis:{
                    renderer:$.jqplot.DateAxisRenderer,
                    tickOptions:{formatString:'%#H:%M'},
                    min: startDateTime,
                    max: ultimateTime,
                    label: "Time",
                    tickInterval: interval
                },
                yaxis: {
                    min: 0,
                    max: ultimateMax * 1.2 ,
                    label: "Estimated BAC",
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    tickInterval: 0.1
                }
            },
            seriesDefaults:{
                showMarker:true,
                pointLabels:{ show:true, location:'s', ypadding:3 }
            },
            series:[
                {showMarker: false, fill: true},
                {fill: true},
                {},
                {showMarker:false}
            ],
            grid: {
                background: '#4b4b4b4b',
                drawGridlines: false
            }
        });
    };

    return {
        draw: function() {
            getDataFromServer();
        }
    };
};
