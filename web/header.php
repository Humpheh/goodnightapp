<?php

/**
 * COMMENTING IS FOR PEOPLE WHO HAVE MORE THAN 30 HOURS TO MAKE SOMETHING
 * 												- Einstein
 */

?>


<html>
	<head>
		<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>
		<script src="js/jquery-ui.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/font-awesome.min.css" />
		<link rel="stylesheet" href="css/jquery-ui.min.css" />
		<link rel="stylesheet" href="css/jquery-ui.structure.min.css" />
		<link rel="stylesheet" href="css/main.css" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,400italic,600italic' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<script>

			$("document").ready(function() {
				$('#history').on('click', '.remove-last-button', function(e){
					e.preventDefault();
					$.post( "action/removelastdrink.php").done(function( data ) {
						$('#history').html(data);

						$.post( "action/getupdatedvals.php").done(function( data ) {
							var obj = jQuery.parseJSON( data );

							$("#units .value").html(obj.units);
							$("#calories .value").html(obj.calories);
							$("#tot-units .value").html(obj.totunits);
							$("#tot-calories .value").html(obj.totcalories);
							var graph = DrunkGraph('drunkChart');
							$('#drunkChart').html("");
							graph.draw();

							per = obj.units / MAXUNITS;
							col = getColorForPercentage(per);
							$('#units').css('background', col);
						});
					});
				});
			});
		</script>
	</head>
	<body>
