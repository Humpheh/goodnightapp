<?php

    $stmt = DB::get()->query('SELECT session_soberby FROM session WHERE session_id = '.$graphid);
    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $max = 0.5;
    $end = $array[0]['session_soberby'];

    $weight = Logins::getCurrentUserWeight();
    $gender = Logins::getCurrentUserGender();
    $maxunits = 0;
    $bw = 0;
    if ($gender == 'male') {
        $maxunits = 4;
        $bw = 0.58;
    } else {
        $maxunits = 3;
        $bw = 0.49;
    }

    $num = 0.806*$maxunits*1.2;
    $den = $bw * $weight;
    $maxbac = $num/$den;
?>
<center><div id="drunkChart" style="">
<div id="tutorial" style="background:url('images/tutorial.png');background-position:center;
    background-repeat:no-repeat;background-size:contain;position:absolute;bottom:0;height:100%;width:100%;"> </div>
</div></center>
<script src="js/plotting/jquery.jqplot.js"></script>
<script src="js/plotting/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script src="js/plotting/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script src="js/plotting/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script src="js/plotting/plugins/jqplot.pointLabels.js"></script>
<script type="text/javascript" src="js/plotting/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="js/plotting/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="js/plotting/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript">
var graphid = <?php echo $graphid; ?>; 
</script>
<script src="js/graph.js"></script>
<link rel="stylesheet" type="text/css" href="js/plotting/jquery.jqplot.css" />
<script>
    endOfAlcohol = new Date("<?php echo $end; ?>");
    maxAlcohol = <?php echo $max ?>;
    maxBac = <?php echo $maxbac ?>;
    $(document).ready(function() {
        var graph = DrunkGraph('drunkChart');
    //    $('#drunkChart').html("");
        graph.draw();
        //DrunkGraph('hangoverChart').draw();
    });
</script>
