<?php

require_once __DIR__ . '/../init.php';

$drinkid = intval($_POST['drinkid']);

$stmt = DB::get()->prepare("SELECT * FROM drink WHERE drink_id = ?");
$stmt->bindValue(1, $drinkid, PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<button type="button" class="close" id="close-info">
    <span aria-hidden="true" style="font-size:40px;">&times;</span><span class="sr-only">Close</span>
</button>

<span>Information</span>
<h2 style="margin-top:0;margin-bottom:20px;"><?php echo str_replace("_", " ", ucfirst($row['drink_name'])); ?></h2>

<?php
$units = round(floatval($row['drink_type1_ml']) * floatval($row['drink_percent']) / 1000, 2);
$calories = floatval($row['drink_calories']) / 1000 * $row['drink_type1_ml'];
?>

<table class="table table-striped" style="background:white;border-radius:4px;overflow:hidden;">
    <tr>
        <td><b>Alcohol Content</b></td>
        <td><?php echo $row['drink_percent']; ?>%</td>
    </tr>
    <tr>
        <td><b>Units</b></td>
        <td><?php echo $units; ?>  <span class="small">per <?php echo $row['drink_type1']; ?></span></td>
    </tr>
    <tr>
        <td><b>Calories</b></td>
        <td><?php echo $calories; ?> <span class="small">per <?php echo $row['drink_type1']; ?></span></td>
    </tr>
    <tr>
        <td><b>Hangover Factor</b></td>
        <td>
            <?php
                $per = round($row['drink_congener'] / 8 * 5);
                if ($row['drink_congener'] < 0) $per = 0;

                for ($i = 0; $i < $per; $i++)
                    echo '<span class="glyphicon glyphicon-star"></span>';

                for ($i = $per; $i < 5; $i++)
                    echo '<span class="glyphicon glyphicon-star-empty"></span>';
            ?>
        </td>
    </tr>
</table>
