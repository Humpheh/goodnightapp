/**
 * Created by kostja on 11/8/14.
 */

var DrunkGraph = function (divElement) {
    var currentBACLine, worstedBACLine, bestBACLine;
    var startDateTime = 'November 8, 2014 8:00PM', interval = '6 hours';

    var setData = function () { //TODO: Get real data
        currentBACLine = [['2014-11-8 9:00PM', 0.1, 'Beer'], ['2014-11-8 9:45PM', 0.2, 'Beer'], ['2014-11-8 10:30PM', 1, 'Vodka Shot']];
        worstedBACLine = new Array();//currentBACLine.slice(0);
        worstedBACLine[0] = currentBACLine[currentBACLine.length -1];
        var worstedBACAdd = [['2014-11-8 11:00PM', 1.1, null], ['2014-11-9 00:00AM', 1.2, null], ['2014-11-9 01:00AM', 2, null]];
        for (var i = 0; i < worstedBACAdd.length; i++) {
            worstedBACLine[worstedBACLine.length] = worstedBACAdd[i];
        }
        bestBACLine = new Array();//currentBACLine.slice(0);
        bestBACLine[0] = currentBACLine[currentBACLine.length - 1];
        var bestBACAdd = [['2014-11-8 11:00PM', 0.9, null], ['2014-11-9 00:00AM', 0.2, null], ['2014-11-9 01:00AM', 0.1, null]];
        for (i = 0; i < bestBACAdd.length; i++) {
            bestBACLine[bestBACLine.length] = bestBACAdd[i];
        }
    };

    return {
        drawGraph: function() {
            setData();
            $.jqplot(divElement, [currentBACLine, worstedBACLine, bestBACLine], {
                title:'BAC',
                axes:{
                    xaxis:{
                        renderer:$.jqplot.DateAxisRenderer,
                        tickOptions:{formatString:'%b %#d, %#I %p'},
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
        }
    };
}