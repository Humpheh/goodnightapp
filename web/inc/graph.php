
<div id="drunkChart" style=""></div>
<script src="js/plotting/jquery.jqplot.js"></script>
<script src="js/plotting/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script src="js/plotting/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script src="js/plotting/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script src="js/plotting/plugins/jqplot.pointLabels.js"></script>
<script type="text/javascript" src="js/plotting/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="js/plotting/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="js/plotting/plugins/jqplot.barRenderer.min.js"></script>
<script src="js/graph.js"></script>
<script>
    $(document).ready(function() {
        var graph = DrunkGraph('drunkChart');
        graph.draw();
        //DrunkGraph('hangoverChart').draw();
    });
</script>
