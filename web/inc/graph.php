<?php
    $stmt = DB::get()->query('SELECT session_soberby FROM session WHERE session_id = '.Logins::getCurrentSession());
    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $max = 0.5;
    $end = $array[0]['session_soberby'];
?>
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
    endOfAlcohol = new Date("<?php echo $end; ?>");
    maxAlcohol = <?php echo $max ?>;
    $(document).ready(function() {
        var graph = DrunkGraph('drunkChart');
        graph.draw();
        //DrunkGraph('hangoverChart').draw();
    });
</script>
