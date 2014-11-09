<?php
    function getEndOFDrinking($sum, $gender, $bodyweight, $start) {
        $BW = ($gender == "female") ? 0.49 : 0.58;
        $MR = ($gender == "female") ? 0.017 : 0.015;
        $top = 0.9 * $sum;
        $bottom = $bodyweight * $BW * $MR;

        return $top/$bottom;
    }

    $stmt = DB::get()->query('SELECT SUM(sessdr_volume*(drink_percent/8))/12.7 as sum, MAX(sessdr_time) as startt FROM sessiondrink LEFT JOIN drink ON drink_id = sessdr_drink_id WHERE sessdr_id = '.Logins::getCurrentSession().';');
    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $drinkingStart = new DateTime($array[0]['startt']);
    $drinkingSum = $array[0]['sum'];

    $end = getEndOFDrinking($drinkingSum, Logins::getCurrentUserGender(), Logins::getCurrentUserWeight(), $drinkingStart->getTimestamp());
    $end = date("Y-m-d H:i:s",$end);
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
    $(document).ready(function() {
        var graph = DrunkGraph('drunkChart');
        graph.draw();
        //DrunkGraph('hangoverChart').draw();
    });
</script>
