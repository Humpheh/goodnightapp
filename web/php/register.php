<?php
	header("Content-Type: application/json");
	$con = mysqli_connect('localhost','maxjmay_cashflow','2ndyearipbath82','maxjmay_moneyapp');
	// Check connection
	if (mysqli_connect_errno())
  	{
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}
  	
  	$array=json_decode($_GET['jsondata']);
  	$hashPassword = md5($array[0] . $array[1]);
	$result = mysqli_query($con,"SELECT * FROM `Users` WHERE Username='{$array[0]}'");
 	
 	//checks if the username already exists
 	if(mysqli_num_rows($result)>=1)
   	{
   		echo $_GET['callback'] . '(' . "{'response' : 'FAILURE'}" . ')';
   	}else{
   		//creates the user if that username doesn't exist already
   		mysqli_query($con,"INSERT INTO `Users` (  `Username` ,  `PasswordUser` ,  `NameUser` , `LastLogin`,  `FoodBudget` ,  `EntBudget` ,  `StudyBudget` ,  `FoodRemaining` , `EntRemaining` ,  `StudyRemaining`, `ResetBudgets` ) 
		VALUES('{$array[0]}','$hashPassword','{$array[2]}','{$array[3]}','{$array[4]}','{$array[5]}','{$array[6]}','{$array[7]}','{$array[8]}','{$array[9]}','{$array[10]}')");
		echo $_GET['callback'] . '(' . "{'response' : 'SUCCESS'}" . ')';
    }
	
	mysqli_close($con);
?>